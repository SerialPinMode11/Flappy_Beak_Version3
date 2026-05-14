@extends('layouts.public-site')

@section('title', 'Create account — JM Casabar Mini Farm')

@section('auth_full_page', true)

@push('styles')
<style>
    .register-input {
        background: #2a4a3a;
        border: 1px solid #3d6b52;
        color: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .register-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    .register-input:focus {
        outline: none;
        border-color: #c9a227;
        box-shadow: 0 0 0 3px rgba(201, 162, 39, 0.15);
    }
    .pw-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s;
    }
    .pw-toggle:hover {
        color: rgba(255,255,255,0.8);
    }
    .feature-card {
        border-left: 3px solid rgba(201, 162, 39, 0.4);
        padding-left: 1rem;
    }
</style>
@endpush

@section('content')
@php
    $pc = $publicContent ?? [];
    $storeName = $pc['store_name'] ?? 'JM Casabar Mini Farm';
@endphp

<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Panel - Registration Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 sm:px-10 py-12 lg:py-8 bg-white min-h-screen lg:min-h-0">
        <div class="w-full max-w-md">
            {{-- Header --}}
            <div class="mb-8">
                <p class="text-gold text-xs font-semibold tracking-[0.2em] uppercase mb-2">Join us today</p>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 mb-1">Create account</h2>
                <p class="text-stone-500 text-sm">at {{ $storeName }}</p>
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
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name"
                           class="w-full px-4 py-3.5 rounded-xl register-input text-sm"
                           placeholder="Juan dela Cruz" required>
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email"
                           class="w-full px-4 py-3.5 rounded-xl register-input text-sm"
                           placeholder="you@example.com" required>
                </div>
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" autocomplete="new-password"
                               class="w-full px-4 py-3.5 rounded-xl register-input text-sm pr-12"
                               placeholder="Min. 8 characters" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('password')" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                               class="w-full px-4 py-3.5 rounded-xl register-input text-sm pr-12"
                               placeholder="Repeat password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation')" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-start gap-2 pt-1">
                    <input type="checkbox" id="terms" name="terms" class="rounded border-stone-300 text-forest focus:ring-gold/50 mt-0.5" required>
                    <label for="terms" class="text-sm text-stone-600 leading-snug cursor-pointer">
                        I agree to the <a href="{{ route('privacy-policy.page') }}" class="font-semibold text-forest underline underline-offset-2 hover:text-forest-light">Privacy Policy</a> and <a href="{{ route('privacy-policy.page') }}" class="font-semibold text-forest underline underline-offset-2 hover:text-forest-light">Terms of Service</a>
                    </label>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-forest-dark text-white font-semibold text-sm tracking-wide hover:bg-forest transition-colors shadow-md">
                    Create account
                </button>
            </form>

            {{-- Sign in link --}}
            <p class="mt-6 text-center text-sm text-stone-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-forest hover:text-forest-light underline decoration-gold/50 underline-offset-2">Sign in</a>
            </p>

            {{-- Social signup --}}
            <div class="mt-6 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-200"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-4 text-stone-400 tracking-widest">Or sign up with</span>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <a href="{{ route('auth.google.redirect') }}" class="flex justify-center items-center gap-2 py-3 px-4 rounded-xl border border-stone-200 bg-white text-stone-700 text-sm font-medium hover:bg-stone-50 hover:border-stone-300 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Google
                </a>
                <a href="{{ route('auth.facebook.redirect') }}" class="flex justify-center items-center gap-2 py-3 px-4 rounded-xl border border-stone-200 bg-white text-stone-700 text-sm font-medium hover:bg-stone-50 hover:border-stone-300 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>

    {{-- Right Panel - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-forest-dark relative overflow-hidden flex-col justify-center items-start px-12 xl:px-16">
        {{-- Decorative elements --}}
        <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
            <div class="absolute top-10 right-10 w-20 h-20 border-2 border-gold/30 rounded-full"></div>
            <div class="absolute bottom-20 left-8 w-32 h-32 border-2 border-gold/20 rounded-full"></div>
            <div class="absolute top-1/3 right-1/4 w-12 h-12 border border-gold/40 rounded-full"></div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 lg:opacity-100 pointer-events-none">
            <div class="absolute top-[calc(50%+180px)] left-1/2 -translate-x-1/2">
                <i class="fas fa-arrow-down text-white/20 text-lg"></i>
            </div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-lg">
            <p class="text-gold/80 text-xs font-semibold tracking-[0.25em] uppercase mb-5">Welcome to the family</p>
            <h1 class="font-serif text-4xl xl:text-5xl text-white font-bold leading-tight mb-6">
                Fresh from the farm,<br><em class="italic text-gold-pale">just for you</em>
            </h1>
            <p class="text-white/70 text-base leading-relaxed mb-10">
                Create your account and enjoy exclusive access to our seasonal drops, incubation bookings, and farm-to-door delivery.
            </p>

            {{-- Feature cards --}}
            <div class="space-y-6">
                <div class="feature-card">
                    <h3 class="text-white font-semibold text-sm mb-1">Farm-to-door delivery</h3>
                    <p class="text-white/60 text-sm">Track your orders in real time from your dashboard.</p>
                </div>
                <div class="feature-card">
                    <h3 class="text-white font-semibold text-sm mb-1">Incubation bookings</h3>
                    <p class="text-white/60 text-sm">Reserve slots and monitor your egg incubation progress.</p>
                </div>
                <div class="feature-card">
                    <h3 class="text-white font-semibold text-sm mb-1">Seasonal drop alerts</h3>
                    <p class="text-white/60 text-sm">Be the first to know when fresh batches are ready.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePw(fieldId) {
        var field = document.getElementById(fieldId);
        var btn = field.nextElementSibling;
        var icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endpush
