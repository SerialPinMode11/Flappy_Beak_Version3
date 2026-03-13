@extends('layouts.static')
@section('title', 'Customer Contacts List - Admin Dashboard')
@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Customer Contacts List</h1>
        
    </div>
</header>
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-20 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th scope="col" class="w-64 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="w-20 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contactDatas as $contactData)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-center">{{ $contactData->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 truncate" title="{{ $contactData->firstname }}">{{ $contactData->firstname }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 truncate" title="{{ $contactData->lastname }}">{{ $contactData->lastname }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @php
                                $fullMessage = $contactData->message;
                                $shortMessage = \Illuminate\Support\Str::limit($fullMessage, 60);
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="truncate" title="{{ $fullMessage }}">{{ $shortMessage }}</span>
                                @if(strlen($fullMessage) > 60)
                                    <button type="button"
                                            class="text-blue-500 text-xs hover:underline"
                                            onclick="openContactMessageModal({{ $contactData->id }})">
                                        See more
                                    </button>
                                @endif
                            </div>
                            @if(strlen($fullMessage) > 60)
                                <div id="contact-message-{{ $contactData->id }}" class="hidden">
                                    {{ $fullMessage }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 truncate" title="{{ $contactData->email }}">{{ $contactData->email }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-center">
                            <a href="mailto:{{ $contactData->email }}"
                               class="inline-flex items-center justify-center text-yellow-500 hover:text-yellow-600 mx-1"
                               title="Reply via email">
                                <i class="fas fa-reply"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No contacts found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $contactDatas->links() }}
    </div>
</div>

@push('scripts')
<script>
    function openContactMessageModal(id) {
        const hidden = document.getElementById('contact-message-' + id);
        if (!hidden) return;
        const message = hidden.textContent || hidden.innerText || '';

        const existing = document.getElementById('contact-message-modal');
        if (existing) existing.remove();

        const wrapper = document.createElement('div');
        wrapper.id = 'contact-message-modal';
        wrapper.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50';
        wrapper.innerHTML = `
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Customer Message</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeContactMessageModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line break-words">${message}</p>
                </div>
                <div class="px-6 py-3 border-t flex justify-end">
                    <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                            onclick="closeContactMessageModal()">
                        Close
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(wrapper);
    }

    function closeContactMessageModal() {
        const modal = document.getElementById('contact-message-modal');
        if (modal) modal.remove();
    }
</script>
@endpush
@endsection