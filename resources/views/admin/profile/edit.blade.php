@extends('layouts.static')

@section('title', 'Admin Profile')
@section('header-title', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div class="flex items-start gap-4">
        <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $activeTab === 'security' ? 'Two-Factor Authentication' : 'Personal Details' }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        {{ $activeTab === 'security' ? 'Secure your admin account with an authenticator app.' : 'Update your admin profile information.' }}
                    </p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 font-semibold">
                    {{ optional($admin)->role ?? 'admin' }}
                </span>
            </div>

            @if($activeTab === 'profile')
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                        <div class="flex items-center gap-4">
                            <img src="{{ $adminPhotoUrl }}" alt="Admin Profile Photo" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                            <div class="flex-1">
                                <input type="file" name="profile_photo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <p class="text-xs text-gray-500 mt-1">Upload JPG/PNG up to 2MB.</p>
                            </div>
                        </div>
                        @error('profile_photo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', optional($admin)->name ?? $adminName) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', optional($admin)->email ?? $adminEmail) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password (optional)</label>
                        <input type="password" name="password" value="" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Leave blank to keep current password">
                        @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">Back</a>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium">Save changes</button>
                    </div>
                </form>
            @else
                <div class="space-y-5">
                    @if(!$isTwoFactorEnabled && !$hasPendingTwoFactor)
                        <p class="text-sm text-gray-600">Two-factor authentication is currently disabled.</p>
                        <form method="POST" action="{{ route('admin.profile.2fa.enable') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">
                                Enable Two-Factor Authentication
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                            <p class="text-sm text-gray-700 mb-3">
                                {{ $isTwoFactorEnabled ? 'Two-factor authentication is enabled.' : 'Scan the QR code using Google Authenticator, Microsoft Authenticator, or Authy.' }}
                            </p>
                            @if($qrCodeUrl)
                                <img src="{{ $qrCodeUrl }}" alt="Two factor QR code" class="w-40 h-40 border border-gray-200 rounded bg-white p-1">
                            @endif
                        </div>

                        @if(!$isTwoFactorEnabled)
                            <form method="POST" action="{{ route('admin.profile.2fa.verify') }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Please enter the code</label>
                                    <input type="text" name="code" inputmode="numeric" maxlength="6" class="w-full max-w-xs px-3 py-2 border border-gray-300 rounded-lg" placeholder="123456">
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-fuchsia-600 hover:bg-fuchsia-700 text-white text-sm font-medium">Confirm</button>
                                    <a href="{{ route('admin.profile.edit', ['tab' => 'security']) }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">Cancel</a>
                                </div>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.2fa.disable') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium">Disable Two-Factor Authentication</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-2">
            <a href="{{ route('admin.profile.edit', ['tab' => 'profile']) }}" class="w-11 h-11 rounded-md border flex items-center justify-center {{ $activeTab === 'profile' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}" title="Profile">
                <i class="fas fa-user"></i>
            </a>
            <a href="{{ route('admin.profile.edit', ['tab' => 'security']) }}" class="w-11 h-11 rounded-md border flex items-center justify-center {{ $activeTab === 'security' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}" title="Security">
                <i class="fas fa-shield-alt"></i>
            </a>
        </div>
    </div>
</div>
@endsection
