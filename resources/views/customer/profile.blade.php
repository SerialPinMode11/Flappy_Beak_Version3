@extends('layouts.public-site')

@section('title', 'Your profile — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    @php
        $avatarUrl = $user->profileAvatarUrl();
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Account</p>
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Your profile</h2>
            <p class="text-sm text-stone-600 mt-2 max-w-2xl">
                Keep your name, photo, and delivery address up to date. Checkout uses this information automatically.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-8 rounded-xl border border-emerald-200 bg-emerald-50/90 text-emerald-900 text-sm px-4 py-3 flex gap-3 items-start">
                <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
                    <h3 class="font-serif text-lg font-semibold text-forest mb-4">Profile photo</h3>
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="" class="h-28 w-28 rounded-full object-cover border-4 border-cream shadow ring-2 ring-stone-200/80">
                            @else
                                <div class="h-28 w-28 rounded-full bg-forest text-gold-pale flex items-center justify-center text-3xl font-serif font-semibold border-4 border-cream shadow ring-2 ring-stone-200/80">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <label class="block w-full text-left text-sm font-medium text-stone-700 mb-2">Upload image</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-stone-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-forest file:text-white file:text-sm file:font-medium hover:file:bg-forest-dark cursor-pointer">
                        <p class="text-xs text-stone-500 mt-2">JPG, PNG, or WebP. Max 2&nbsp;MB.</p>
                        @if($user->avatar_path)
                            <label class="mt-4 flex items-center justify-center gap-2 text-sm text-stone-600 cursor-pointer">
                                <input type="checkbox" name="remove_avatar" value="1" class="rounded border-stone-300 text-forest focus:ring-gold/40">
                                Remove current photo
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
                    <h3 class="font-serif text-lg font-semibold text-forest mb-6">Personal details</h3>
                    <div class="space-y-4 max-w-xl">
                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Full name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full p-2.5 border border-stone-100 rounded-lg bg-stone-50 text-stone-500 cursor-not-allowed">
                            <p class="text-xs text-stone-500 mt-1">Sign-in email cannot be changed here.</p>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone <span class="text-stone-400 font-normal">(optional)</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest" placeholder="e.g. +63 9xx xxx xxxx">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
                    <h3 class="font-serif text-lg font-semibold text-forest mb-2">Default delivery address</h3>
                    <p class="text-sm text-stone-600 mb-6">Used at checkout for every order. You can update it anytime.</p>
                    <div class="space-y-4 max-w-xl">
                        <div>
                            <label for="address" class="block text-sm font-medium text-stone-700 mb-1">Street address</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" required class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest" placeholder="House / unit, street, barangay">
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-stone-700 mb-1">City / municipality</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" required class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest">
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="zip" class="block text-sm font-medium text-stone-700 mb-1">ZIP code</label>
                                <input type="text" id="zip" name="zip" value="{{ old('zip', $user->zip) }}" required class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest">
                                @error('zip')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-forest text-white px-6 py-3 rounded-xl hover:bg-forest-dark transition-colors font-medium shadow-sm">
                        <i class="fas fa-save"></i> Save profile
                    </button>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-stone-200 text-stone-700 hover:bg-cream transition-colors font-medium">
                        Back to shop
                    </a>
                </div>
            </div>
        </form>
    </main>
@endsection
