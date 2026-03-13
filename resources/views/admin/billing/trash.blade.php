@extends('layouts.static')
@section('title', 'Billing Trash - Admin Dashboard')
@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Billing Trash</h1>
        <a href="{{ route('admin.billing.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Back to Billing
        </a>
    </div>
</header>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="w-full table-fixed divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-12 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="w-56 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                    <th class="w-40 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted At</th>
                    <th class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($billingInfo as $info)
                    <tr>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900 text-center">{{ $info->id }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div class="font-medium">{{ $info->name }}</div>
                            <div class="text-xs text-gray-500">{{ $info->email }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $info->address }}, {{ $info->city }}, {{ $info->zip }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ ucfirst($info->payment_method) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            ₱{{ number_format($info->total_amount, 2) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $info->deleted_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <form action="{{ route('admin.billing.restore', $info->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center justify-center text-emerald-600 hover:text-emerald-700 mx-1"
                                        title="Restore">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.billing.forceDelete', $info->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center text-red-600 hover:text-red-700 mx-1"
                                        onclick="return confirm('Permanently delete this billing record? This cannot be undone.')"
                                        title="Delete forever">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">
                            No billing records in trash.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $billingInfo->links() }}
    </div>
</div>
@endsection

