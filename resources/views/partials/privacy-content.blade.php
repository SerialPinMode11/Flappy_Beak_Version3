@php
    $pr = $publicOthers['privacy'] ?? [];
@endphp
<!-- Hero Section -->
<div class="bg-gradient-to-br from-forest via-forest-dark to-forest-dark text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-20 h-20 bg-white/15 rounded-full flex items-center justify-center mx-auto mb-6 ring-2 ring-gold/30">
                <i class="fas fa-shield-alt text-3xl text-gold-pale"></i>
            </div>
            <h1 class="font-serif text-4xl md:text-5xl font-semibold mb-4">{{ $pr['hero_title'] ?? 'Privacy Policy' }}</h1>
            <p class="text-lg md:text-xl mb-6 text-white/85">{{ $pr['hero_subtitle'] ?? 'Your privacy is important to us' }}</p>
            <div class="bg-white bg-opacity-10 rounded-lg p-4 inline-block">
                <p class="text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Last Updated: <span class="font-semibold">{{ date('F d, Y') }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-cream py-16 border-t border-stone-200/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <section id="overview" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['dpa_title'] ?? '' }}</h2>
            <p class="text-stone-700 mb-5">{{ $pr['dpa_text'] ?? '' }}</p>
            <h3 class="text-xl font-semibold text-forest mb-2">{{ $pr['overview_title'] ?? '' }}</h3>
            <p class="text-stone-700 mb-4">{{ $pr['overview_text'] ?? '' }}</p>
            <div class="bg-cream/80 p-4 rounded-lg border border-stone-200/80 space-y-1 text-stone-700">
                <p><strong>Company:</strong> {{ $pr['company_name'] ?? '' }}</p>
                <p><strong>Address:</strong> {{ $pr['company_address'] ?? '' }}</p>
                <p><strong>Contact:</strong> {{ !empty(trim($pr['company_contact'] ?? '')) ? $pr['company_contact'] : config('contact.owner_phone_display') }}</p>
                <p><strong>Data Protection Officer:</strong> {{ $pr['company_dpo'] ?? '' }}</p>
            </div>
        </section>

        <section id="information-collection" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['collect_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['collect_subtitle'] ?? '' }}</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Personal Information</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['collect_personal'] ?? '' }}</div></div>
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Transaction Information</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['collect_transaction'] ?? '' }}</div></div>
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Technical Information</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['collect_technical'] ?? '' }}</div></div>
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Communication Data</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['collect_communication'] ?? '' }}</div></div>
            </div>
        </section>

        <section id="information-use" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['use_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['use_subtitle'] ?? '' }}</p>
            @for($i = 1; $i <= 5; $i++)
                <div class="border-l-4 border-gold/70 pl-4 mb-4">
                    <h4 class="font-semibold text-stone-800 mb-1">{{ $pr['use_'.$i.'_title'] ?? '' }}</h4>
                    <p class="text-stone-600">{{ $pr['use_'.$i.'_text'] ?? '' }}</p>
                </div>
            @endfor
        </section>

        <section id="information-sharing" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['share_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['share_subtitle'] ?? '' }}</p>
            <div class="bg-amber-50/90 border border-amber-200/80 rounded-lg p-4 mb-4 text-amber-900">{{ $pr['share_notice'] ?? '' }}</div>
            @for($i = 1; $i <= 3; $i++)
                <div class="bg-cream/80 p-4 rounded-lg border border-stone-200/80 mb-3">
                    <h4 class="font-semibold text-stone-800 mb-1">{{ $pr['share_'.$i.'_title'] ?? '' }}</h4>
                    <p class="text-stone-600">{{ $pr['share_'.$i.'_text'] ?? '' }}</p>
                </div>
            @endfor
        </section>

        <section id="data-security" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['security_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-2">{{ $pr['security_subtitle'] ?? '' }}</p>
            <p class="text-stone-700 mb-4">{{ $pr['security_intro'] ?? '' }}</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Technical Safeguards</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['security_technical'] ?? '' }}</div></div>
                <div class="border border-stone-200/80 rounded-lg p-4"><h4 class="font-semibold mb-2">Organizational Measures</h4><div class="whitespace-pre-line text-stone-700">{{ $pr['security_org'] ?? '' }}</div></div>
            </div>
        </section>

        <section id="your-rights" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['rights_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['rights_subtitle'] ?? '' }}</p>
            <div class="grid md:grid-cols-2 gap-4">
                @for($i = 1; $i <= 8; $i++)
                    <div class="border border-stone-200/80 rounded-lg p-4">
                        <h4 class="font-semibold mb-1">{{ $pr['rights_'.$i.'_title'] ?? '' }}</h4>
                        <p class="text-stone-600 text-sm">{{ $pr['rights_'.$i.'_text'] ?? '' }}</p>
                    </div>
                @endfor
            </div>
            <div class="mt-4 bg-cream/80 p-4 rounded-lg border border-stone-200/80">
                <p class="text-stone-700 mb-1">{{ $pr['rights_how'] ?? '' }}</p>
                <p class="text-sm text-stone-500">{{ $pr['rights_note'] ?? '' }}</p>
            </div>
        </section>

        <section id="cookies" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['cookies_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-2">{{ $pr['cookies_subtitle'] ?? '' }}</p>
            <p class="text-stone-700 mb-4">{{ $pr['cookies_intro'] ?? '' }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @for($i = 1; $i <= 3; $i++)
                    <div class="border border-stone-200/80 rounded-lg p-4">
                        <h4 class="font-semibold mb-1">{{ $pr['cookies_'.$i.'_title'] ?? '' }}</h4>
                        <p class="text-stone-600 text-sm">{{ $pr['cookies_'.$i.'_text'] ?? '' }}</p>
                    </div>
                @endfor
            </div>
        </section>

        <section id="data-retention" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['retention_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-2">{{ $pr['retention_subtitle'] ?? '' }}</p>
            <p class="text-stone-700 mb-4">{{ $pr['retention_intro'] ?? '' }}</p>
            @for($i = 1; $i <= 3; $i++)
                <div class="border border-stone-200/80 rounded-lg p-4 mb-3">
                    <h4 class="font-semibold mb-1">{{ $pr['retention_'.$i.'_title'] ?? '' }}</h4>
                    <p class="text-stone-600">{{ $pr['retention_'.$i.'_text'] ?? '' }}</p>
                </div>
            @endfor
        </section>

        <section id="contact" class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['contact_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['contact_subtitle'] ?? '' }}</p>
            <p class="text-stone-700 mb-4">{{ $pr['contact_intro'] ?? '' }}</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-stone-200/80 rounded-lg p-4">
                    <h4 class="font-semibold mb-2">{{ $pr['contact_company_title'] ?? '' }}</h4>
                    <p class="text-stone-700">{{ $pr['contact_company_address'] ?? '' }}</p>
                    <p class="text-stone-700">{{ !empty(trim($pr['contact_company_phone'] ?? '')) ? $pr['contact_company_phone'] : config('contact.owner_phone_display') }}</p>
                    <p class="text-stone-700">{{ $pr['contact_company_email'] ?? '' }}</p>
                </div>
                <div class="border border-stone-200/80 rounded-lg p-4">
                    <h4 class="font-semibold mb-2">{{ $pr['contact_npc_title'] ?? '' }}</h4>
                    <p class="text-stone-700 mb-2">{{ $pr['contact_npc_text'] ?? '' }}</p>
                    <p class="text-stone-700">{{ $pr['contact_npc_web'] ?? '' }}</p>
                    <p class="text-stone-700">{{ $pr['contact_npc_email'] ?? '' }}</p>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 sm:p-8">
            <h2 class="font-serif text-2xl font-semibold text-forest mb-2">{{ $pr['updates_title'] ?? '' }}</h2>
            <p class="text-stone-600 mb-4">{{ $pr['updates_subtitle'] ?? '' }}</p>
            <p class="text-stone-700 mb-4">{{ $pr['updates_intro'] ?? '' }}</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-stone-200/80 rounded-lg p-4">
                    <h4 class="font-semibold mb-1">{{ $pr['updates_email_title'] ?? '' }}</h4>
                    <p class="text-stone-600">{{ $pr['updates_email_text'] ?? '' }}</p>
                </div>
                <div class="border border-stone-200/80 rounded-lg p-4">
                    <h4 class="font-semibold mb-1">{{ $pr['updates_site_title'] ?? '' }}</h4>
                    <p class="text-stone-600">{{ $pr['updates_site_text'] ?? '' }}</p>
                </div>
            </div>
            <div class="mt-4 bg-amber-50/90 p-4 rounded-lg border border-amber-200/80 text-amber-900">
                {{ $pr['updates_note'] ?? '' }}
            </div>
        </section>
    </div>
</div>

{{-- <div class="bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-3xl md:text-4xl font-bold mb-4">{{ $pr['footer_title'] ?? '' }}</h3>
            <p class="text-xl mb-8 opacity-90">{{ $pr['footer_subtitle'] ?? '' }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-slate-800 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200">
                    {{ $pr['footer_btn_1'] ?? 'Contact Us' }}
                </a>
                <a href="{{ $privacyCtaHomeUrl ?? url('/') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-slate-800 transition-colors duration-200">
                    {{ $pr['footer_btn_2'] ?? 'Back to Home' }}
                </a>
            </div>
        </div>
    </div>
</div> --}}
