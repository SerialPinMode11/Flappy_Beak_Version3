@extends('layouts.static')
@section('title', 'Customer Contacts List - Admin Dashboard')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Customer Contacts List</h1>
        
    </div>
</header>
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-20 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                        <th scope="col" class="w-32 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th scope="col" class="w-64 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="w-32 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Reply Status</th>
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
                        <td class="px-4 py-3 text-sm text-center">
                            @if($contactData->replied_at)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    Replied
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-center">
                            <button type="button"
                               class="inline-flex items-center justify-center text-yellow-500 hover:text-yellow-600 mx-1"
                               title="Reply to customer"
                               onclick='openReplyModal(@json($contactData->id), @json($contactData->email), @json(trim($contactData->firstname . " " . $contactData->lastname)))'>
                                <i class="fas fa-reply"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No contacts found</td>
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

<div id="reply-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Reply to Customer</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeReplyModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('contactforlist.reply') }}" id="reply-form" class="px-6 py-5 space-y-4">
            @csrf
            <input type="hidden" id="contact_id" name="contact_id">
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Message Subject</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message Body</label>
                <div id="quill-editor" class="bg-white" style="height: 220px;"></div>
                <textarea id="message_body_fallback" class="hidden w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-2" rows="8" placeholder="Write your message here..."></textarea>
                <input type="hidden" id="message_body" name="message_body" required>
            </div>

            <div>
                <label for="receiver_email" class="block text-sm font-medium text-gray-700 mb-1">Receiver Email/Gmail</label>
                <input
                    type="email"
                    id="receiver_email"
                    name="receiver_email"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required
                >
            </div>

            <div class="pt-2 flex items-center justify-end gap-2">
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                    onclick="closeReplyModal()"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Send Reply
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    let replyQuill = null;
    let useQuillFallback = false;

    function ensureReplyEditor() {
        if (replyQuill) return;
        if (useQuillFallback) return;

        if (typeof Quill === 'undefined') {
            useQuillFallback = true;
            document.getElementById('quill-editor').classList.add('hidden');
            document.getElementById('message_body_fallback').classList.remove('hidden');
            return;
        }

        try {
            replyQuill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link', 'blockquote', 'code-block'],
                        ['clean']
                    ]
                }
            });
        } catch (error) {
            useQuillFallback = true;
            document.getElementById('quill-editor').classList.add('hidden');
            document.getElementById('message_body_fallback').classList.remove('hidden');
        }
    }

    function openReplyModal(contactId, email, fullName) {
        const modal = document.getElementById('reply-modal');
        const contactIdInput = document.getElementById('contact_id');
        const receiverInput = document.getElementById('receiver_email');
        const subjectInput = document.getElementById('subject');
        const fallbackInput = document.getElementById('message_body_fallback');

        ensureReplyEditor();

        contactIdInput.value = contactId || '';
        receiverInput.value = email || '';
        subjectInput.value = fullName ? `RE: Your inquiry, ${fullName}` : 'RE: Your inquiry';
        if (replyQuill) {
            replyQuill.root.innerHTML = '';
        }
        fallbackInput.value = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeReplyModal() {
        const modal = document.getElementById('reply-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.getElementById('reply-form').addEventListener('submit', function (event) {
        const messageBody = document.getElementById('message_body');
        const fallbackInput = document.getElementById('message_body_fallback');

        if (useQuillFallback || !replyQuill) {
            const plainFallback = fallbackInput.value.trim();
            if (!plainFallback) {
                event.preventDefault();
                alert('Please enter a message before sending.');
                return;
            }
            messageBody.value = plainFallback.replace(/\n/g, '<br>');
            return;
        }

        const html = replyQuill.root.innerHTML.trim();
        const plain = replyQuill.getText().trim();
        if (!plain) {
            event.preventDefault();
            alert('Please enter a message before sending.');
            return;
        }

        messageBody.value = html;
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeReplyModal();
            closeContactMessageModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('reply_success'))
            if (typeof window.showToast === 'function') {
                window.showToast(@json(session('reply_success')), 'success');
            }
        @endif

        @if(session('reply_error'))
            if (typeof window.showToast === 'function') {
                window.showToast(@json(session('reply_error')), 'error');
            }
        @endif
    });

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