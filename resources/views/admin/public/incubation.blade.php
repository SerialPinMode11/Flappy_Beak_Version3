@extends('layouts.static')

@section('title', 'Public · Incubation Details')
@section('header-title', 'Public · Incubation Details')
@section('header-subtitle', 'Edit customer incubation page cards, factors, prices, images, and icons.')

@push('styles')
<style>
    .editor-section summary { cursor: pointer; list-style: none; }
    .editor-section summary::-webkit-details-marker { display: none; }
    .editor-section[open] .chev { transform: rotate(180deg); }
    .editor-section .chev { transition: transform .2s ease; }
    .image-preview {
        width: 100%;
        max-width: 260px;
        height: 140px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        background: #f9fafb;
    }
</style>
@endpush

@section('content')
@php
    $toStorageUrl = function ($path) {
        if (blank($path)) {
            return null;
        }

        return str_starts_with((string) $path, 'http')
            ? $path
            : asset('storage/' . ltrim((string) $path, '/'));
    };
@endphp
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

        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 text-sm text-indigo-800">
            Tip: Open one section at a time, save often, and avoid changing all cards at once.
        </div>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm" open>
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Hero</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
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
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm" open>
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Service Cards (4)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
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
                            <div class="space-y-2">
                                <label class="inline-flex items-center gap-2 text-xs font-medium text-gray-700">
                                    <input type="checkbox" name="replace_service_image[{{ $i }}]" value="1" data-toggle-image-input="service_image_input_{{ $i }}" {{ old('replace_service_image.' . $i) ? 'checked' : '' }}>
                                    Replace image (ON to upload new, OFF to keep current)
                                </label>
                                <input id="service_image_input_{{ $i }}" type="file" name="service_images[{{ $i }}]" class="w-full border rounded px-3 py-2" data-preview-target="service_image_preview_{{ $i }}">
                                @if($toStorageUrl($svc['image'] ?? null))
                                    <img id="service_image_preview_{{ $i }}" src="{{ $toStorageUrl($svc['image']) }}" alt="Current Service Image {{ $i + 1 }}" class="image-preview">
                                @else
                                    <img id="service_image_preview_{{ $i }}" src="" alt="Service Image Preview {{ $i + 1 }}" class="image-preview hidden">
                                @endif
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Incubation Details Section</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
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
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Factors (8 with icon classes)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
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
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Why Choose List + CTA</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
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
        </details>

        <div class="sticky bottom-4 z-20 flex justify-end">
            <button type="submit" class="shadow-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg">
                Save Incubation Details
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const toggles = document.querySelectorAll('[data-toggle-image-input]');

        toggles.forEach(function (toggle) {
            const inputId = toggle.getAttribute('data-toggle-image-input');
            const fileInput = document.getElementById(inputId);
            if (!fileInput) return;

            const setState = function () {
                const enabled = toggle.checked;
                fileInput.disabled = !enabled;
                fileInput.classList.toggle('opacity-60', !enabled);
                fileInput.classList.toggle('cursor-not-allowed', !enabled);
                if (!enabled) {
                    fileInput.value = '';
                }
            };

            setState();
            toggle.addEventListener('change', setState);

            fileInput.addEventListener('change', function (event) {
                const targetId = fileInput.getAttribute('data-preview-target');
                const preview = targetId ? document.getElementById(targetId) : null;
                const file = event.target.files && event.target.files[0];
                if (!preview || !file) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });
        });
    })();
</script>
@endpush
