@extends('layouts.static')

@section('title', 'Public Content')
@section('header-title', 'Public Page Content')
@section('header-subtitle', 'Edit store branding, text, and images shown on the public landing page.')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.public.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">Store Branding</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Store Name</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $content['store_name']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Store Logo</label>
                    <input type="file" name="store_logo" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">Hero Section</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Hero Title</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $content['hero_title']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Hero Image</label>
                    <input type="file" name="hero_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm mb-1">Hero Subtitle</label>
                <textarea name="hero_subtitle" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('hero_subtitle', $content['hero_subtitle']) }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">About Section</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">About Title</label>
                    <input type="text" name="about_title" value="{{ old('about_title', $content['about_title']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">About Image</label>
                    <input type="file" name="about_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm mb-1">Paragraph 1</label>
                    <textarea name="about_paragraph_1" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('about_paragraph_1', $content['about_paragraph_1']) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm mb-1">Paragraph 2</label>
                    <textarea name="about_paragraph_2" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('about_paragraph_2', $content['about_paragraph_2']) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm mb-1">Paragraph 3</label>
                    <textarea name="about_paragraph_3" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('about_paragraph_3', $content['about_paragraph_3']) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">Stats</h2>
            <div class="grid md:grid-cols-4 gap-4">
                @for($i = 1; $i <= 4; $i++)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <label class="block text-xs mb-1">Number {{ $i }}</label>
                        <input type="text" name="stat_{{ $i }}_number" value="{{ old("stat_{$i}_number", $content["stat_{$i}_number"]) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2">
                        <label class="block text-xs mb-1">Label {{ $i }}</label>
                        <input type="text" name="stat_{{ $i }}_label" value="{{ old("stat_{$i}_label", $content["stat_{$i}_label"]) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">Why Choose Section</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Section Title</label>
                    <input type="text" name="features_title" value="{{ old('features_title', $content['features_title']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Section Subtitle</label>
                    <input type="text" name="features_subtitle" value="{{ old('features_subtitle', $content['features_subtitle']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                @for($i = 1; $i <= 4; $i++)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <label class="block text-xs mb-1">Feature {{ $i }} title</label>
                        <input type="text" name="feature_{{ $i }}_title" value="{{ old("feature_{$i}_title", $content["feature_{$i}_title"]) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2">
                        <label class="block text-xs mb-1">Feature {{ $i }} text</label>
                        <textarea name="feature_{{ $i }}_text" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old("feature_{$i}_text", $content["feature_{$i}_text"]) }}</textarea>
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-lg font-semibold mb-4">Footer and Contact</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Footer Brand Name</label>
                    <input type="text" name="footer_brand_name" value="{{ old('footer_brand_name', $content['footer_brand_name']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $content['contact_email']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm mb-1">Footer Brand Description</label>
                <textarea name="footer_brand_text" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('footer_brand_text', $content['footer_brand_text']) }}</textarea>
            </div>
            <div class="mt-4">
                <label class="block text-sm mb-1">Address</label>
                <textarea name="contact_address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('contact_address', $content['contact_address']) }}</textarea>
            </div>
            <div class="grid md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm mb-1">Business Hours #1</label>
                    <input type="text" name="business_hours_1" value="{{ old('business_hours_1', $content['business_hours_1']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Business Hours #2</label>
                    <input type="text" name="business_hours_2" value="{{ old('business_hours_2', $content['business_hours_2']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Business Hours #3</label>
                    <input type="text" name="business_hours_3" value="{{ old('business_hours_3', $content['business_hours_3']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg">
                Save Public Content
            </button>
        </div>
    </form>
</div>
@endsection
