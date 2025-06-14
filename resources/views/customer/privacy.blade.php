@extends('layouts.default')

@section('title', 'Privacy Policy - JM Casabar Private Farm')

@push('styles')
<style>
    .scroll-smooth {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 text-white">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shield-alt text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Privacy Policy</h1>
            <p class="text-xl md:text-2xl mb-6 opacity-90">Your privacy is important to us</p>
            <div class="bg-white bg-opacity-10 rounded-lg p-4 inline-block">
                <p class="text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Last Updated: <span class="font-semibold">{{ date('F d, Y') }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Navigation -->
<div class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex overflow-x-auto py-4 space-x-6 text-sm">
            <a href="#overview" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Overview</a>
            <a href="#information-collection" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Information Collection</a>
            <a href="#information-use" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">How We Use Information</a>
            <a href="#information-sharing" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Information Sharing</a>
            <a href="#data-security" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Data Security</a>
            <a href="#your-rights" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Your Rights</a>
            <a href="#cookies" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Cookies</a>
            <a href="#contact" class="whitespace-nowrap text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Contact Us</a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <!-- DPA Compliance Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-gavel text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Data Privacy Act Compliance</h3>
                    <p class="text-blue-700 leading-relaxed">
                        This Privacy Policy is designed to comply with the <strong>Data Privacy Act of 2012 (Republic Act No. 10173)</strong> 
                        and its Implementing Rules and Regulations. We are committed to protecting your personal data in accordance with Philippine law.
                    </p>
                </div>
            </div>
        </div>

        <!-- Overview Section -->
        <section id="overview" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Overview</h2>
                            <p class="opacity-90">Understanding our commitment to your privacy</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed mb-4">
                            JM Casabar Private Farm ("we," "our," or "us") respects your privacy and is committed to protecting your personal data. 
                            This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, 
                            purchase our products, or use our services.
                        </p>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-building mr-2 text-gray-600"></i>
                                Data Controller Information
                            </h4>
                            <div class="text-gray-700 space-y-1">
                                <p><strong>Company:</strong> JM Casabar Private Farm</p>
                                <p><strong>Address:</strong> Bacoor, Calabarzon, Philippines</p>
                                <p><strong>Contact:</strong> [Your contact information]</p>
                                <p><strong>Data Protection Officer:</strong> [DPO contact if applicable]</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Information Collection Section -->
        <section id="information-collection" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-database text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Information We Collect</h2>
                            <p class="opacity-90">Types of personal data we may collect from you</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Personal Information
                            </h4>
                            <ul class="space-y-2 text-blue-700">
                                <li>• Full name</li>
                                <li>• Email address</li>
                                <li>• Phone number</li>
                                <li>• Mailing address</li>
                                <li>• Date of birth (for age verification)</li>
                            </ul>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h4 class="font-semibold text-purple-800 mb-3 flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Transaction Information
                            </h4>
                            <ul class="space-y-2 text-purple-700">
                                <li>• Order history</li>
                                <li>• Payment information</li>
                                <li>• Delivery preferences</li>
                                <li>• Product preferences</li>
                                <li>• Communication records</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                            <h4 class="font-semibold text-orange-800 mb-3 flex items-center">
                                <i class="fas fa-globe mr-2"></i>
                                Technical Information
                            </h4>
                            <ul class="space-y-2 text-orange-700">
                                <li>• IP address</li>
                                <li>• Browser type and version</li>
                                <li>• Device information</li>
                                <li>• Usage data</li>
                                <li>• Cookies and tracking data</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                <i class="fas fa-comments mr-2"></i>
                                Communication Data
                            </h4>
                            <ul class="space-y-2 text-green-700">
                                <li>• Customer service inquiries</li>
                                <li>• Feedback and reviews</li>
                                <li>• Survey responses</li>
                                <li>• Marketing preferences</li>
                                <li>• Social media interactions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Information Use Section -->
        <section id="information-use" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-cogs text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">How We Use Your Information</h2>
                            <p class="opacity-90">Lawful purposes for processing your personal data</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="border-l-4 border-blue-400 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Order Processing and Fulfillment</h4>
                            <p class="text-gray-600">To process your orders, arrange delivery, handle payments, and provide customer support.</p>
                        </div>
                        <div class="border-l-4 border-green-400 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Communication</h4>
                            <p class="text-gray-600">To send order confirmations, delivery updates, respond to inquiries, and provide important notices.</p>
                        </div>
                        <div class="border-l-4 border-purple-400 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Marketing and Promotions</h4>
                            <p class="text-gray-600">To send promotional materials, special offers, and newsletters (with your consent).</p>
                        </div>
                        <div class="border-l-4 border-orange-400 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Legal Compliance</h4>
                            <p class="text-gray-600">To comply with legal obligations, including tax requirements and regulatory compliance.</p>
                        </div>
                        <div class="border-l-4 border-red-400 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Business Operations</h4>
                            <p class="text-gray-600">To improve our services, conduct analytics, prevent fraud, and ensure website security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Information Sharing Section -->
        <section id="information-sharing" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-share-alt text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Information Sharing and Disclosure</h2>
                            <p class="opacity-90">When and how we may share your information</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-yellow-800 mb-1">Important Notice</h4>
                                <p class="text-yellow-700">We do not sell, trade, or rent your personal information to third parties for their marketing purposes.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-truck mr-2 text-gray-600"></i>
                                Service Providers
                            </h4>
                            <p class="text-gray-600">We may share information with trusted third-party service providers who assist us in operating our business (delivery services, payment processors, IT support).</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-balance-scale mr-2 text-gray-600"></i>
                                Legal Requirements
                            </h4>
                            <p class="text-gray-600">We may disclose information when required by law, court order, or government regulation, or to protect our rights and safety.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-handshake mr-2 text-gray-600"></i>
                                Business Transfers
                            </h4>
                            <p class="text-gray-600">In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of the business transaction.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Data Security Section -->
        <section id="data-security" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-lock text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Data Security</h2>
                            <p class="opacity-90">How we protect your personal information</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        We implement appropriate technical and organizational security measures to protect your personal data against unauthorized access, 
                        alteration, disclosure, or destruction.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Technical Safeguards
                            </h4>
                            <ul class="space-y-2 text-green-700">
                                <li>• SSL encryption for data transmission</li>
                                <li>• Secure servers and databases</li>
                                <li>• Regular security updates</li>
                                <li>• Firewall protection</li>
                                <li>• Access controls and authentication</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                Organizational Measures
                            </h4>
                            <ul class="space-y-2 text-blue-700">
                                <li>• Staff training on data protection</li>
                                <li>• Limited access on need-to-know basis</li>
                                <li>• Regular security assessments</li>
                                <li>• Data breach response procedures</li>
                                <li>• Confidentiality agreements</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Your Rights Section -->
        <section id="your-rights" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Your Rights Under the Data Privacy Act</h2>
                            <p class="opacity-90">Your rights as a data subject in the Philippines</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Right to be Informed
                                </h4>
                                <p class="text-blue-700 text-sm">You have the right to know how your personal data is being processed.</p>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                    <i class="fas fa-search mr-2"></i>
                                    Right to Access
                                </h4>
                                <p class="text-green-700 text-sm">You can request access to your personal data that we hold.</p>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <h4 class="font-semibold text-purple-800 mb-2 flex items-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Right to Rectification
                                </h4>
                                <p class="text-purple-700 text-sm">You can request correction of inaccurate or incomplete personal data.</p>
                            </div>
                            
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                <h4 class="font-semibold text-red-800 mb-2 flex items-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Right to Erasure
                                </h4>
                                <p class="text-red-700 text-sm">You can request deletion of your personal data under certain circumstances.</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                <h4 class="font-semibold text-orange-800 mb-2 flex items-center">
                                    <i class="fas fa-ban mr-2"></i>
                                    Right to Object
                                </h4>
                                <p class="text-orange-700 text-sm">You can object to the processing of your personal data for certain purposes.</p>
                            </div>
                            
                            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                                <h4 class="font-semibold text-indigo-800 mb-2 flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Right to Data Portability
                                </h4>
                                <p class="text-indigo-700 text-sm">You can request your personal data in a structured, commonly used format.</p>
                            </div>
                            
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-pause mr-2"></i>
                                    Right to Restrict Processing
                                </h4>
                                <p class="text-yellow-700 text-sm">You can request limitation of processing under certain conditions.</p>
                            </div>
                            
                            <div class="bg-pink-50 p-4 rounded-lg border border-pink-200">
                                <h4 class="font-semibold text-pink-800 mb-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Right to File Complaints
                                </h4>
                                <p class="text-pink-700 text-sm">You can file complaints with the National Privacy Commission.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            How to Exercise Your Rights
                        </h4>
                        <p class="text-gray-600 mb-2">To exercise any of these rights, please contact us using the information provided in the Contact section below. We will respond to your request within the timeframe required by law.</p>
                        <p class="text-sm text-gray-500">Note: Some rights may be subject to certain conditions and exceptions as provided by law.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cookies Section -->
        <section id="cookies" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-cookie-bite text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Cookies and Tracking Technologies</h2>
                            <p class="opacity-90">How we use cookies and similar technologies</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        We use cookies and similar tracking technologies to enhance your browsing experience, analyze website traffic, 
                        and personalize content. You can control cookie settings through your browser preferences.
                    </p>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                <i class="fas fa-cog mr-2"></i>
                                Essential Cookies
                            </h4>
                            <p class="text-blue-700 text-sm">Required for website functionality and security.</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Analytics Cookies
                            </h4>
                            <p class="text-green-700 text-sm">Help us understand how visitors use our website.</p>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h4 class="font-semibold text-purple-800 mb-2 flex items-center">
                                <i class="fas fa-bullhorn mr-2"></i>
                                Marketing Cookies
                            </h4>
                            <p class="text-purple-700 text-sm">Used to deliver relevant advertisements and track campaigns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Data Retention Section -->
        <section id="data-retention" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Data Retention</h2>
                            <p class="opacity-90">How long we keep your personal information</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        We retain your personal data only for as long as necessary to fulfill the purposes for which it was collected, 
                        comply with legal obligations, resolve disputes, and enforce our agreements.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">Account Information</h4>
                            <p class="text-gray-600">Retained while your account is active and for 7 years after account closure for legal compliance.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">Transaction Records</h4>
                            <p class="text-gray-600">Retained for 10 years as required by Philippine tax and business laws.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-2">Marketing Communications</h4>
                            <p class="text-gray-600">Retained until you unsubscribe or withdraw consent.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-600 to-slate-700 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Contact Us</h2>
                            <p class="opacity-90">Get in touch regarding privacy matters</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        If you have any questions about this Privacy Policy, wish to exercise your rights, or have concerns about how we handle your personal data, 
                        please contact us using the information below:
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                <i class="fas fa-building mr-2"></i>
                                JM Casabar Private Farm
                            </h4>
                            <div class="space-y-2 text-blue-700">
                                <p class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                    Bacoor, Calabarzon, Philippines
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-phone mr-2 w-4"></i>
                                    [Your phone number]
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-envelope mr-2 w-4"></i>
                                    [Your email address]
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                National Privacy Commission
                            </h4>
                            <div class="space-y-2 text-red-700">
                                <p>If you believe we have violated your privacy rights, you may file a complaint with:</p>
                                <p class="flex items-center">
                                    <i class="fas fa-globe mr-2 w-4"></i>
                                    www.privacy.gov.ph
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-envelope mr-2 w-4"></i>
                                    info@privacy.gov.ph
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Updates Section -->
        <section class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-6 text-white">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-sync-alt text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Policy Updates</h2>
                            <p class="opacity-90">How we handle changes to this privacy policy</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We may update this Privacy Policy from time to time to reflect changes in our practices, technology, legal requirements, or other factors. 
                        When we make material changes, we will notify you by:
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                <i class="fas fa-bell mr-2"></i>
                                Email Notification
                            </h4>
                            <p class="text-blue-700 text-sm">Sending notice to your registered email address</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                <i class="fas fa-bullhorn mr-2"></i>
                                Website Notice
                            </h4>
                            <p class="text-green-700 text-sm">Posting a prominent notice on our website</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <p class="text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Your continued use of our services after the effective date of any changes constitutes your acceptance of the revised Privacy Policy.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- Footer CTA -->
<div class="bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shield-alt text-3xl"></i>
            </div>
            <h3 class="text-3xl md:text-4xl font-bold mb-4">Your Privacy Matters</h3>
            <p class="text-xl mb-8 opacity-90">We are committed to protecting your personal data and respecting your privacy rights under Philippine law.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-slate-800 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Our Privacy Team
                </a>
                <a href="{{ route('home') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-slate-800 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Highlight active section in navigation
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('text-blue-600', 'font-semibold');
        link.classList.add('text-gray-600');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.remove('text-gray-600');
            link.classList.add('text-blue-600', 'font-semibold');
        }
    });
});
</script>
@endpush