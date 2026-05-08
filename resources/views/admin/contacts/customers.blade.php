@extends('layouts.static')
@section('title', 'Customer Accounts - Admin Dashboard')
@section('header-title', 'Customer Accounts')
@section('header-subtitle', 'View all registered customer accounts that can access the customer dashboard and product pages.')

@section('content')
@php
    $search = request('q', '');
    $nameSort = request('name_sort', '');
    $nextNameSort = $nameSort === 'asc' ? 'desc' : 'asc';
@endphp
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Registered Customer Users</h2>
            <div class="flex flex-col items-start gap-2">
                <span class="text-sm text-gray-500">Total on this page: {{ $customers->count() }}</span>
                <form method="GET" action="{{ route('contactforlist.customers') }}" id="customerSearchForm" class="w-full">
                    <input
                        type="text"
                        id="customerSearchInput"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Search Name, Email, Phone, City, Registered Date..."
                        class="w-80 max-w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @if(in_array($nameSort, ['asc', 'desc'], true))
                        <input type="hidden" name="name_sort" value="{{ $nameSort }}">
                    @endif
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a
                                href="{{ route('contactforlist.customers', array_filter(['q' => $search ?: null, 'name_sort' => $nextNameSort])) }}"
                                class="inline-flex items-center gap-1 hover:text-indigo-600"
                                title="Sort by Name"
                            >
                                Name
                                @if($nameSort === 'asc')
                                    <i class="fas fa-sort-alpha-down text-indigo-500"></i>
                                @elseif($nameSort === 'desc')
                                    <i class="fas fa-sort-alpha-up text-indigo-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $customer->phone ?: 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $customer->city ?: 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                @if($customer->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Verified</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Unverified</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($customer->created_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-sm text-gray-500">No customer accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('customerSearchForm');
        const input = document.getElementById('customerSearchInput');
        if (!form || !input) return;

        let debounceTimer = null;
        const initialValue = (input.value || '').trim();

        input.addEventListener('input', function () {
            if (debounceTimer) {
                clearTimeout(debounceTimer);
            }

            debounceTimer = setTimeout(function () {
                const currentValue = (input.value || '').trim();
                if (currentValue === initialValue) return;
                form.submit();
            }, 350);
        });
    })();
</script>
@endpush
@endsection

