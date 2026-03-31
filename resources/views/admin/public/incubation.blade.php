@extends('layouts.static')

@section('title', 'Public · Incubation Details')
@section('header-title', 'Public · Incubation Details')
@section('header-subtitle', 'Edit customer incubation page cards, factors, prices, images, and icons.')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    @if(session('success'))
        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $data = old() ?: $incubation;
        $services = $data['services'] ?? [];
        $factors = $data['factors'] ?? [];
        $whyItems = $data['why_items'] ?? [];
    @endphp

    <form method="POST" action="{{ route('admin.public.incubation.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <h2 class="text-lg font-semibold">Hero</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Eyebrow</label>
                    <input type="text" name="eyebrow" value="{{ $data['eyebrow'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="text-sm block mb-1">Title</label>
                    <input type="text" name="title" value="{{ $data['title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <h2 class="text-lg font-semibold">Service Cards (4)</h2>
            <div class="grid lg:grid-cols-2 gap-4">
                @for($i = 0; $i < 4; $i++)
                    @php $svc = $services[$i] ?? []; @endphp
                    <div class="border rounded-lg p-4 space-y-3">
                        <p class="font-semibold text-sm">Card {{ $i + 1 }}</p>
                        <input type="text" name="services[{{ $i }}][badge]" value="{{ $svc['badge'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Badge">
                        <input type="text" name="services[{{ $i }}][title]" value="{{ $svc['title'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Title">
                        <textarea name="services[{{ $i }}][description]" rows="4" class="w-full border rounded px-3 py-2" placeholder="Description">{{ $svc['description'] ?? '' }}</textarea>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="services[{{ $i }}][price]" value="{{ $svc['price'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Price">
                            <input type="text" name="services[{{ $i }}][price_note]" value="{{ $svc['price_note'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Price note">
                            <input type="text" name="services[{{ $i }}][rating]" value="{{ $svc['rating'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Rating (e.g. 4.5)">
                            <input type="text" name="services[{{ $i }}][reviews]" value="{{ $svc['reviews'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Review count">
                        </div>
                        <div>
                            <label class="text-sm block mb-1">Card Image (optional replace)</label>
                            <input type="file" name="service_images[{{ $i }}]" class="w-full border rounded px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Current: {{ $svc['image'] ?? '' }}</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <h2 class="text-lg font-semibold">Incubation Details Section</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Section title</label>
                    <input type="text" name="details_title" value="{{ $data['details_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="text-sm block mb-1">Why box title</label>
                    <input type="text" name="why_title" value="{{ $data['why_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
            <div>
                <label class="text-sm block mb-1">Section description</label>
                <textarea name="details_text" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $data['details_text'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <h2 class="text-lg font-semibold">Factors (8 with icon classes)</h2>
            <div class="grid lg:grid-cols-2 gap-4">
                @for($i = 0; $i < 8; $i++)
                    @php $f = $factors[$i] ?? []; @endphp
                    <div class="border rounded-lg p-3 space-y-2">
                        <p class="text-sm font-semibold">Factor {{ $i + 1 }}</p>
                        <input type="text" name="factors[{{ $i }}][icon]" value="{{ $f['icon'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Icon class, e.g. fas fa-temperature-high">
                        <input type="text" name="factors[{{ $i }}][title]" value="{{ $f['title'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Title">
                        <textarea name="factors[{{ $i }}][description]" rows="2" class="w-full border rounded px-3 py-2" placeholder="Description">{{ $f['description'] ?? '' }}</textarea>
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <h2 class="text-lg font-semibold">Why Choose List + CTA</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @for($i = 0; $i < 8; $i++)
                    <div>
                        <label class="text-sm block mb-1">Why item {{ $i + 1 }}</label>
                        <input type="text" name="why_items[{{ $i }}]" value="{{ $whyItems[$i] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                    </div>
                @endfor
            </div>
            <div>
                <label class="text-sm block mb-1">Book button text</label>
                <input type="text" name="book_button" value="{{ $data['book_button'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>

        <div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg">
                Save Incubation Details
            </button>
        </div>
    </form>
</div>
@endsection
