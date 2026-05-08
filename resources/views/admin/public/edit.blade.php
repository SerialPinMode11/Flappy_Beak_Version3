@extends('layouts.static')

@section('title', 'Public Content')
@section('header-title', 'Public Page Content')
@section('header-subtitle', 'Edit store branding, text, and images shown on the public landing page.')

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

        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 text-sm text-indigo-800">
            Update only what you need. Each block below can be collapsed to reduce noise while editing.
        </div>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200" open>
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Store Branding</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Store Name</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $content['store_name']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Store Logo</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center gap-2 text-xs font-medium text-gray-700">
                            <input type="checkbox" name="replace_store_logo" value="1" data-toggle-image-input="store_logo_input" {{ old('replace_store_logo') ? 'checked' : '' }}>
                            Replace image (ON to upload new, OFF to keep current)
                        </label>
                        <input id="store_logo_input" type="file" name="store_logo" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" data-preview-target="store_logo_preview">
                        @if($toStorageUrl($content['store_logo'] ?? null))
                            <img id="store_logo_preview" src="{{ $toStorageUrl($content['store_logo']) }}" alt="Current Store Logo" class="image-preview">
                        @else
                            <img id="store_logo_preview" src="" alt="Store Logo Preview" class="image-preview hidden">
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200" open>
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Hero Section</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Hero Title</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $content['hero_title']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Hero Image</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center gap-2 text-xs font-medium text-gray-700">
                            <input type="checkbox" name="replace_hero_image" value="1" data-toggle-image-input="hero_image_input" {{ old('replace_hero_image') ? 'checked' : '' }}>
                            Replace image (ON to upload new, OFF to keep current)
                        </label>
                        <input id="hero_image_input" type="file" name="hero_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" data-preview-target="hero_image_preview">
                        @if($toStorageUrl($content['hero_image'] ?? null))
                            <img id="hero_image_preview" src="{{ $toStorageUrl($content['hero_image']) }}" alt="Current Hero Image" class="image-preview">
                        @else
                            <img id="hero_image_preview" src="" alt="Hero Image Preview" class="image-preview hidden">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm mb-1">Hero Subtitle</label>
                <textarea name="hero_subtitle" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('hero_subtitle', $content['hero_subtitle']) }}</textarea>
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">About Section</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">About Title</label>
                    <input type="text" name="about_title" value="{{ old('about_title', $content['about_title']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">About Image</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center gap-2 text-xs font-medium text-gray-700">
                            <input type="checkbox" name="replace_about_image" value="1" data-toggle-image-input="about_image_input" {{ old('replace_about_image') ? 'checked' : '' }}>
                            Replace image (ON to upload new, OFF to keep current)
                        </label>
                        <input id="about_image_input" type="file" name="about_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" data-preview-target="about_image_preview">
                        @if($toStorageUrl($content['about_image'] ?? null))
                            <img id="about_image_preview" src="{{ $toStorageUrl($content['about_image']) }}" alt="Current About Image" class="image-preview">
                        @else
                            <img id="about_image_preview" src="" alt="About Image Preview" class="image-preview hidden">
                        @endif
                    </div>
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
        </details>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Stats</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
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
        </details>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Why Choose Section</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
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
        </details>

        <details class="editor-section bg-white rounded-xl shadow-sm border border-gray-200">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Footer and Contact</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5">
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
        </details>

        <div class="sticky bottom-4 z-20 flex justify-end">
            <button type="submit" class="shadow-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg">
                Save Public Content
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
