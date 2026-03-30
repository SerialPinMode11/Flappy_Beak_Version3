@extends('layouts.public-site')

@section('title', 'Sign in — JM Casabar Mini Farm')

@push('styles')
<style>
    .auth-card {
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.12), 0 0 0 1px rgb(26 61 46 / 0.06);
    }
</style>
@endpush

@section('content')
@php
    $pc = $publicContent ?? [];
    $storeName = $pc['store_name'] ?? 'JM Casabar Mini Farm';
@endphp

<div class="relative min-h-[calc(100vh-8rem)] flex flex-col items-center justify-center px-4 py-12 lg:py-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none z-0 opacity-[0.07] bg-[radial-gradient(circle_at_30%_20%,#1a3d2e_0%,transparent_50%),radial-gradient(circle_at_80%_80%,#c9a227_0%,transparent_45%)]"></div>
    @include('partials.auth-duck-tracks-bg')

    <div class="relative z-10 w-full max-w-md auth-card rounded-2xl overflow-hidden bg-white border border-stone-200/90">
        <div class="bg-forest px-6 pt-8 pb-10 text-center relative">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-gold/80 via-gold to-gold-pale/80"></div>
            <p class="text-gold-pale/90 text-[0.65rem] font-semibold tracking-[0.2em] uppercase mb-3">Established 2020</p>
            <h1 class="font-serif text-2xl sm:text-3xl text-white font-semibold leading-tight">{{ $storeName }}</h1>
            <p class="mt-2 text-sm text-white/75">Sign in to continue shopping and checkout.</p>
        </div>

        <div class="px-6 sm:px-8 py-8">
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

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="login-email" class="block text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">Email</label>
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-cream/50 text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-forest transition-shadow"
                           placeholder="you@example.com" required>
                </div>
                <div>
                    <label for="login-password" class="block text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">Password</label>
                    <input type="password" id="login-password" name="password" autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-cream/50 text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-forest transition-shadow"
                           placeholder="••••••••" required>
                </div>
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="remember" name="remember" class="rounded border-stone-300 text-forest focus:ring-gold/50">
                        <span class="text-sm text-stone-600">Remember me</span>
                    </label>
                    <span class="text-sm text-stone-400">Forgot password? Contact support.</span>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-forest text-white font-semibold text-sm tracking-wide hover:bg-forest-light transition-colors shadow-md">
                    Sign in
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-stone-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="font-semibold text-forest hover:text-forest-light underline decoration-gold/50 underline-offset-2">Create one</a>
            </p>

            <div class="mt-8 pt-8 border-t border-stone-100">
                <p class="text-center text-xs text-stone-400 uppercase tracking-widest mb-4">Or continue with</p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('auth.google.redirect') }}" class="flex justify-center items-center py-2.5 px-3 rounded-xl border border-stone-200 bg-white text-stone-600 hover:bg-cream hover:border-gold/30 transition-colors" aria-label="Continue with Google">
                        <i class="fab fa-google text-lg text-red-500"></i>
                    </a>
                    <a href="{{ route('auth.facebook.redirect') }}" class="flex justify-center items-center py-2.5 px-3 rounded-xl border border-stone-200 bg-white text-stone-600 hover:bg-cream hover:border-gold/30 transition-colors" aria-label="Continue with Facebook">
                        <i class="fab fa-facebook text-lg text-blue-600"></i>
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-forest hover:text-forest-light transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Back to home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
