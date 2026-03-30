@extends('layouts.public-site')

@section('title', 'Create account — JM Casabar Mini Farm')

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
    <div class="absolute inset-0 pointer-events-none z-0 opacity-[0.07] bg-[radial-gradient(circle_at_70%_30%,#1a3d2e_0%,transparent_50%),radial-gradient(circle_at_20%_70%,#c9a227_0%,transparent_45%)]"></div>
    @include('partials.auth-duck-tracks-bg')

    <div class="relative z-10 w-full max-w-md auth-card rounded-2xl overflow-hidden bg-white border border-stone-200/90">
        <div class="bg-forest px-6 pt-8 pb-10 text-center relative">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-gold/80 via-gold to-gold-pale/80"></div>
            <p class="text-gold-pale/90 text-[0.65rem] font-semibold tracking-[0.2em] uppercase mb-3">Join the reserve</p>
            <h1 class="font-serif text-2xl sm:text-3xl text-white font-semibold leading-tight">Create your account</h1>
            <p class="mt-2 text-sm text-white/75">Shop farm-fresh duck products with {{ $storeName }}.</p>
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

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">Full name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-cream/50 text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-forest transition-shadow"
                           placeholder="Your name" required>
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-cream/50 text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-forest transition-shadow"
                           placeholder="you@example.com" required>
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">Password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-cream/50 text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-forest transition-shadow"
                           placeholder="Create a secure password" required>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-forest text-white font-semibold text-sm tracking-wide hover:bg-forest-light transition-colors shadow-md">
                    Create account
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-stone-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-forest hover:text-forest-light underline decoration-gold/50 underline-offset-2">Sign in</a>
            </p>

            <div class="mt-8 pt-8 border-t border-stone-100">
                <p class="text-center text-xs text-stone-400 uppercase tracking-widest mb-4">Or continue with</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="flex justify-center items-center py-2.5 px-3 rounded-xl border border-stone-200 bg-white text-stone-600 hover:bg-cream hover:border-gold/30 transition-colors" aria-label="Google">
                        <i class="fab fa-google text-lg text-red-500"></i>
                    </button>
                    <button type="button" class="flex justify-center items-center py-2.5 px-3 rounded-xl border border-stone-200 bg-white text-stone-600 hover:bg-cream hover:border-gold/30 transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook text-lg text-blue-600"></i>
                    </button>
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
