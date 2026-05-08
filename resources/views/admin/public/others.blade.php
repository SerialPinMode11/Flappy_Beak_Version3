@extends('layouts.static')

@section('title', 'Public · Others')
@section('header-title', 'Public · Others')
@section('header-subtitle', 'Edit all non-product public page content using text fields only.')

@push('styles')
<style>
    .editor-section summary { cursor: pointer; list-style: none; }
    .editor-section summary::-webkit-details-marker { display: none; }
    .editor-section[open] .chev { transform: rotate(180deg); }
    .editor-section .chev { transition: transform .2s ease; }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    @if(session('success'))
        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $c = old('contact', $others['contact'] ?? []);
        $a = old('about', $others['about'] ?? []);
        $fq = old('faq', $others['faq'] ?? []);
        $pr = old('privacy', $others['privacy'] ?? []);
    @endphp

    <form method="POST" action="{{ route('admin.public.others.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 text-sm text-indigo-800">
            This page has many fields. Expand only the section you are currently updating to avoid overload.
        </div>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm" open>
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Contact Us (red box only)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="text-sm block mb-1">Location label</label><input type="text" name="contact[location_label]" value="{{ $c['location_label'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Location text</label><input type="text" name="contact[location_text]" value="{{ $c['location_text'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Phone label</label><input type="text" name="contact[phone_label]" value="{{ $c['phone_label'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Phone text</label><input type="text" name="contact[phone_text]" value="{{ $c['phone_text'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Email label</label><input type="text" name="contact[email_label]" value="{{ $c['email_label'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Email text</label><input type="text" name="contact[email_text]" value="{{ $c['email_text'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Facebook label</label><input type="text" name="contact[facebook_label]" value="{{ $c['facebook_label'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Facebook display text</label><input type="text" name="contact[facebook_text]" value="{{ $c['facebook_text'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div class="md:col-span-2"><label class="text-sm block mb-1">Facebook URL</label><input type="text" name="contact[facebook_url]" value="{{ $c['facebook_url'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">About Us (red box only)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2"><label class="text-sm block mb-1">Story title</label><input type="text" name="about[story_title]" value="{{ $a['story_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Story paragraph 1</label><textarea name="about[story_p1]" rows="4" class="w-full border rounded-lg px-3 py-2">{{ $a['story_p1'] ?? '' }}</textarea></div>
                <div><label class="text-sm block mb-1">Story paragraph 2</label><textarea name="about[story_p2]" rows="4" class="w-full border rounded-lg px-3 py-2">{{ $a['story_p2'] ?? '' }}</textarea></div>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach([1,2,3] as $n)
                    <div class="border rounded-lg p-3 space-y-2">
                        <p class="text-sm font-semibold">Card {{ $n }}</p>
                        <input type="text" name="about[card{{ $n }}_title]" value="{{ $a['card'.$n.'_title'] ?? '' }}" class="w-full border rounded px-2 py-1" placeholder="Title">
                        <textarea name="about[card{{ $n }}_text]" rows="3" class="w-full border rounded px-2 py-1" placeholder="Description">{{ $a['card'.$n.'_text'] ?? '' }}</textarea>
                    </div>
                @endforeach
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">FAQ page (all content)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="text-sm block mb-1">Hero title</label><input type="text" name="faq[hero_title]" value="{{ $fq['hero_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Hero subtitle</label><input type="text" name="faq[hero_subtitle]" value="{{ $fq['hero_subtitle'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Search placeholder</label><input type="text" name="faq[search_placeholder]" value="{{ $fq['search_placeholder'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
            </div>
            <div class="grid md:grid-cols-4 gap-4">
                @foreach([1,2,3,4] as $n)
                    <div>
                        <label class="text-sm block mb-1">Stat {{ $n }} number</label>
                        <input type="text" name="faq[stat_{{ $n }}_number]" value="{{ $fq['stat_'.$n.'_number'] ?? '' }}" class="w-full border rounded-lg px-3 py-2 mb-2">
                        <label class="text-sm block mb-1">Stat {{ $n }} label</label>
                        <input type="text" name="faq[stat_{{ $n }}_label]" value="{{ $fq['stat_'.$n.'_label'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                    </div>
                @endforeach
            </div>

            @php
                $faqGroups = [['general',5], ['wine',3], ['duck',2], ['incubation',2]];
            @endphp
            @foreach($faqGroups as [$group,$count])
                <div class="border rounded-lg p-4 space-y-3">
                    <div class="grid md:grid-cols-2 gap-3">
                        <div><label class="text-sm block mb-1">{{ ucfirst($group) }} section title</label><input type="text" name="faq[{{ $group }}_title]" value="{{ $fq[$group.'_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                        <div><label class="text-sm block mb-1">{{ ucfirst($group) }} subtitle</label><input type="text" name="faq[{{ $group }}_subtitle]" value="{{ $fq[$group.'_subtitle'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                    </div>
                    @for($i=1; $i<=$count; $i++)
                        <div class="grid md:grid-cols-2 gap-3">
                            <div><label class="text-sm block mb-1">Q{{ $i }}</label><input type="text" name="faq[{{ $group }}_q{{ $i }}]" value="{{ $fq[$group.'_q'.$i] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                            <div><label class="text-sm block mb-1">A{{ $i }}</label><textarea name="faq[{{ $group }}_a{{ $i }}]" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $fq[$group.'_a'.$i] ?? '' }}</textarea></div>
                        </div>
                    @endfor
                </div>
            @endforeach

            <div class="grid md:grid-cols-2 gap-3">
                <div><label class="text-sm block mb-1">Bottom CTA title</label><input type="text" name="faq[cta_title]" value="{{ $fq['cta_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Bottom CTA subtitle</label><input type="text" name="faq[cta_subtitle]" value="{{ $fq['cta_subtitle'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Contact button text</label><input type="text" name="faq[cta_button_contact]" value="{{ $fq['cta_button_contact'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="text-sm block mb-1">Call button text</label><input type="text" name="faq[cta_button_call]" value="{{ $fq['cta_button_call'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
                <div class="md:col-span-2"><label class="text-sm block mb-1">Bottom note</label><input type="text" name="faq[cta_bottom_note]" value="{{ $fq['cta_bottom_note'] ?? '' }}" class="w-full border rounded-lg px-3 py-2"></div>
            </div>
            </div>
        </details>

        <details class="editor-section bg-white rounded-xl border border-gray-200 shadow-sm">
            <summary class="px-5 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-lg font-semibold">Privacy Policy (all content)</h2>
                <i class="fas fa-chevron-down chev text-gray-400"></i>
            </summary>
            <div class="p-5 space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    'hero_title' => 'Hero title', 'hero_subtitle' => 'Hero subtitle',
                    'dpa_title' => 'DPA title', 'dpa_text' => 'DPA text',
                    'overview_title' => 'Overview title', 'overview_subtitle' => 'Overview subtitle', 'overview_text' => 'Overview text',
                    'company_name' => 'Company name', 'company_address' => 'Company address', 'company_contact' => 'Company contact', 'company_dpo' => 'Data protection officer text'
                ] as $key => $label)
                    <div class="{{ str_contains($key, '_text') || str_contains($key, 'address') ? 'md:col-span-2' : '' }}">
                        <label class="text-sm block mb-1">{{ $label }}</label>
                        @if(str_contains($key, '_text') || str_contains($key, 'address'))
                            <textarea name="privacy[{{ $key }}]" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $pr[$key] ?? '' }}</textarea>
                        @else
                            <input type="text" name="privacy[{{ $key }}]" value="{{ $pr[$key] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    'collect_title' => 'Collection title', 'collect_subtitle' => 'Collection subtitle',
                    'collect_personal' => 'Collection - personal (one per line)',
                    'collect_transaction' => 'Collection - transaction (one per line)',
                    'collect_technical' => 'Collection - technical (one per line)',
                    'collect_communication' => 'Collection - communication (one per line)',
                    'use_title' => 'Use title', 'use_subtitle' => 'Use subtitle',
                    'share_title' => 'Sharing title', 'share_subtitle' => 'Sharing subtitle',
                    'share_notice' => 'Sharing notice',
                    'security_title' => 'Security title', 'security_subtitle' => 'Security subtitle', 'security_intro' => 'Security intro',
                    'security_technical' => 'Technical safeguards (one per line)',
                    'security_org' => 'Organizational measures (one per line)',
                    'rights_title' => 'Rights title', 'rights_subtitle' => 'Rights subtitle',
                    'rights_how' => 'How to exercise rights',
                    'rights_note' => 'Rights note',
                    'cookies_title' => 'Cookies title', 'cookies_subtitle' => 'Cookies subtitle', 'cookies_intro' => 'Cookies intro',
                    'retention_title' => 'Retention title', 'retention_subtitle' => 'Retention subtitle', 'retention_intro' => 'Retention intro',
                    'contact_title' => 'Contact section title', 'contact_subtitle' => 'Contact subtitle', 'contact_intro' => 'Contact intro',
                    'contact_company_title' => 'Contact company card title', 'contact_company_address' => 'Contact company address', 'contact_company_phone' => 'Contact company phone', 'contact_company_email' => 'Contact company email',
                    'contact_npc_title' => 'NPC card title', 'contact_npc_text' => 'NPC text', 'contact_npc_web' => 'NPC web', 'contact_npc_email' => 'NPC email',
                    'updates_title' => 'Updates title', 'updates_subtitle' => 'Updates subtitle', 'updates_intro' => 'Updates intro',
                    'updates_email_title' => 'Updates email card title', 'updates_email_text' => 'Updates email card text',
                    'updates_site_title' => 'Updates website card title', 'updates_site_text' => 'Updates website card text', 'updates_note' => 'Updates note',
                    'footer_title' => 'Footer title', 'footer_subtitle' => 'Footer subtitle', 'footer_btn_1' => 'Footer button 1', 'footer_btn_2' => 'Footer button 2'
                ] as $key => $label)
                    <div class="{{ str_contains($label, '(one per line)') || str_contains($key, '_intro') || str_contains($key, '_note') || str_contains($key, 'address') || str_contains($key, '_text') ? 'md:col-span-2' : '' }}">
                        <label class="text-sm block mb-1">{{ $label }}</label>
                        @if(str_contains($label, '(one per line)') || str_contains($key, '_intro') || str_contains($key, '_note') || str_contains($key, 'address') || str_contains($key, '_text'))
                            <textarea name="privacy[{{ $key }}]" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $pr[$key] ?? '' }}</textarea>
                        @else
                            <input type="text" name="privacy[{{ $key }}]" value="{{ $pr[$key] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @for($i = 1; $i <= 8; $i++)
                    <div>
                        <label class="text-sm block mb-1">Right {{ $i }} title</label>
                        <input type="text" name="privacy[rights_{{ $i }}_title]" value="{{ $pr['rights_'.$i.'_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2 mb-2">
                        <label class="text-sm block mb-1">Right {{ $i }} description</label>
                        <textarea name="privacy[rights_{{ $i }}_text]" rows="2" class="w-full border rounded-lg px-3 py-2">{{ $pr['rights_'.$i.'_text'] ?? '' }}</textarea>
                    </div>
                @endfor
                @for($i = 1; $i <= 3; $i++)
                    <div>
                        <label class="text-sm block mb-1">Cookie Card {{ $i }} title</label>
                        <input type="text" name="privacy[cookies_{{ $i }}_title]" value="{{ $pr['cookies_'.$i.'_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2 mb-2">
                        <label class="text-sm block mb-1">Cookie Card {{ $i }} description</label>
                        <textarea name="privacy[cookies_{{ $i }}_text]" rows="2" class="w-full border rounded-lg px-3 py-2">{{ $pr['cookies_'.$i.'_text'] ?? '' }}</textarea>
                    </div>
                @endfor
                @for($i = 1; $i <= 3; $i++)
                    <div>
                        <label class="text-sm block mb-1">Retention Card {{ $i }} title</label>
                        <input type="text" name="privacy[retention_{{ $i }}_title]" value="{{ $pr['retention_'.$i.'_title'] ?? '' }}" class="w-full border rounded-lg px-3 py-2 mb-2">
                        <label class="text-sm block mb-1">Retention Card {{ $i }} description</label>
                        <textarea name="privacy[retention_{{ $i }}_text]" rows="2" class="w-full border rounded-lg px-3 py-2">{{ $pr['retention_'.$i.'_text'] ?? '' }}</textarea>
                    </div>
                @endfor
            </div>
            </div>
        </details>

        <div class="sticky bottom-4 z-20 flex justify-end">
            <button type="submit" class="shadow-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg">Save Others</button>
        </div>
    </form>
</div>
@endsection
