<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin 2FA Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-2">Two-Factor Authentication</h1>
        <p class="text-sm text-gray-600 mb-4">Enter the 6-digit code from your authenticator app to continue.</p>

        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-700 text-sm">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.2fa.challenge.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Authenticator code</label>
                <input type="text" name="code" maxlength="6" inputmode="numeric" autocomplete="one-time-code" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="123456" required>
                @error('code')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium">
                Verify and Log In
            </button>
            <a href="{{ route('admin.login') }}" class="block text-center text-sm text-gray-600 hover:text-gray-800">Back to login</a>
        </form>
    </div>
</body>
</html>
