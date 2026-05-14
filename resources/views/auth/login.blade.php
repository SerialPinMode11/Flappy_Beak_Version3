@extends('layouts.public-site')

@section('title', 'Sign in — JM Casabar Mini Farm')

@section('auth_full_page', true)

@push('styles')
<style>
    .login-input {
        background: #2a4a3a;
        border: 1px solid #3d6b52;
        color: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .login-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    .login-input:focus {
        outline: none;
        border-color: #c9a227;
        box-shadow: 0 0 0 3px rgba(201, 162, 39, 0.15);
    }
    .gold-ring {
        border: 2px solid rgba(201, 162, 39, 0.3);
        border-radius: 50%;
        position: absolute;
    }
    .gold-ring-lg {
        width: 320px;
        height: 320px;
        top: -60px;
        right: -80px;
        border-width: 3px;
        border-color: rgba(201, 162, 39, 0.25);
    }
    .gold-ring-md {
        width: 200px;
        height: 200px;
        bottom: 80px;
        left: -60px;
        border-color: rgba(201, 162, 39, 0.2);
    }
    .gold-ring-sm {
        width: 80px;
        height: 80px;
        top: 40%;
        right: 15%;
        border-color: rgba(201, 162, 39, 0.35);
    }
    .gold-dot {
        position: absolute;
        border-radius: 50%;
        background: rgba(201, 162, 39, 0.4);
    }
</style>
@endpush

@section('content')
@php
    $pc = $publicContent ?? [];
    $storeName = $pc['store_name'] ?? 'JM Casabar Mini Farm';
@endphp

<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Panel - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-forest-dark relative overflow-hidden flex-col justify-center items-start px-12 xl:px-20">
        {{-- Decorative gold rings --}}
        <div class="gold-ring gold-ring-lg"></div>
        <div class="gold-ring gold-ring-md"></div>
        <div class="gold-ring gold-ring-sm"></div>
        <div class="gold-dot" style="width: 8px; height: 8px; top: 20%; left: 25%;"></div>
        <div class="gold-dot" style="width: 6px; height: 6px; bottom: 30%; right: 25%;"></div>
        <div class="gold-dot" style="width: 10px; height: 10px; top: 60%; left: 10%;"></div>

        {{-- Content --}}
        <div class="relative z-10 max-w-lg">
            <p class="text-gold/80 text-xs font-semibold tracking-[0.25em] uppercase mb-5">Established 2020</p>
            <h1 class="font-serif text-4xl xl:text-5xl text-white font-bold leading-tight mb-6">
                Premium <em class="italic">farm-raised</em><br>duck & artisan goods
            </h1>
            <p class="text-white/70 text-base leading-relaxed mb-10">
                Fresh duck eggs, free-range poultry, and hand-crafted products — straight from our mini farm to your table.
            </p>

            {{-- Badges --}}
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-900/60 border border-emerald-700/40 text-emerald-200 text-sm font-medium">
                    <i class="fas fa-leaf text-xs"></i> Free-range
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-900/50 border border-amber-700/40 text-amber-200 text-sm font-medium">
                    <i class="fas fa-seedling text-xs"></i> Farm fresh
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-rose-900/50 border border-rose-700/40 text-rose-200 text-sm font-medium">
                    <i class="fas fa-heart text-xs"></i> Family owned
                </span>
            </div>
        </div>
    </div>

    {{-- Right Panel - Login Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 sm:px-10 py-12 lg:py-8 bg-white min-h-screen lg:min-h-0">
        <div class="w-full max-w-md">
            {{-- Header --}}
            <div class="mb-8">
                <p class="text-gold text-xs font-semibold tracking-[0.2em] uppercase mb-2">Welcome back</p>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 mb-1">Sign in</h2>
                <p class="text-stone-500 text-sm">to {{ $storeName }}</p>
            </div>

            {{-- Alerts --}}
            @if(session()->has('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50/90 text-emerald-900 text-sm px-4 py-3 flex gap-3 items-start">
                    <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
                    <span>{{ session()->get('success') }}</span>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50/90 text-red-900 text-sm px-4 py-3 flex gap-3 items-start">
                    <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                    <span>{{ session()->get('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50/90 text-amber-950 text-sm px-4 py-3">
                    <p class="font-medium mb-1">Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-amber-900/90">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="login-email" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Email Address</label>
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" autocomplete="email"
                           class="w-full px-4 py-3.5 rounded-xl login-input text-sm"
                           placeholder="you@example.com" required>
                </div>
                <div>
                    <label for="login-password" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Password</label>
                    <input type="password" id="login-password" name="password" autocomplete="current-password"
                           class="w-full px-4 py-3.5 rounded-xl login-input text-sm"
                           placeholder="••••••••" required>
                </div>
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="remember" name="remember" class="rounded border-stone-300 text-forest focus:ring-gold/50">
                        <span class="text-sm text-stone-600">Remember me</span>
                    </label>
                    <span class="text-sm text-stone-400">Forgot password? Contact support.</span>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-forest-dark text-white font-semibold text-sm tracking-wide hover:bg-forest transition-colors shadow-md">
                    Sign in
                </button>
            </form>

            {{-- Register link --}}
            <p class="mt-6 text-center text-sm text-stone-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-forest hover:text-forest-light underline decoration-gold/50 underline-offset-2">Create one</a>
            </p>

            {{-- Social login --}}
            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-200"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-4 text-stone-400 tracking-widest">Or</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="{{ route('auth.google.redirect') }}" class="flex justify-center items-center gap-2 py-3 px-4 rounded-xl border border-stone-200 bg-white text-stone-700 text-sm font-medium hover:bg-stone-50 hover:border-stone-300 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Google
                </a>
                <a href="{{ route('auth.facebook.redirect') }}" class="flex justify-center items-center gap-2 py-3 px-4 rounded-xl border border-stone-200 bg-white text-stone-700 text-sm font-medium hover:bg-stone-50 hover:border-stone-300 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>

            {{-- Back to home --}}
            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-stone-500 hover:text-forest transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Back to home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
