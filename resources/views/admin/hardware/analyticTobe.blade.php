@extends('layouts.hardware')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            50% { opacity: 0.8; box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        .pulse-animation {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .feature-icon:hover::before {
            left: 100%;
        }

        .feature-icon:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .progress-ring {
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .stagger-animation > * {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .stagger-animation > *:nth-child(1) { animation-delay: 0.1s; }
        .stagger-animation > *:nth-child(2) { animation-delay: 0.2s; }
        .stagger-animation > *:nth-child(3) { animation-delay: 0.3s; }
        .stagger-animation > *:nth-child(4) { animation-delay: 0.4s; }
        .stagger-animation > *:nth-child(5) { animation-delay: 0.5s; }
        .stagger-animation > *:nth-child(6) { animation-delay: 0.6s; }

        .gradient-border {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #667eea 0%, #764ba2 100%) border-box;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-6xl mx-auto">

            <!-- Hero Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-gradient-to-br from-primary to-purple-600 mb-6 float-animation">
                    <i class="fas fa-chart-line text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Feeding Control <span class="text-primary">Analytics</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Deep insights into your feeding operations
                </p>
            </div>

            <!-- Main Coming Soon Section -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden gradient-border mb-8 transform transition-all duration-300 hover:shadow-3xl">
                
                <!-- Status Banner -->
                <div class="bg-gradient-to-r from-primary/10 to-purple-600/10 px-6 py-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="flex h-3 w-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                            </span>
                            <span class="text-sm font-semibold text-primary">
                                <i class="fas fa-code-branch mr-2"></i>
                                Analytics Platform • Under Active Development
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i>
                            Estimated Launch: Q4 2024
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="px-8 py-12 md:px-12">
                    <div class="max-w-4xl mx-auto">
                        <!-- Main Announcement -->
                        <div class="text-center mb-12">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                                Advanced Analytics Are <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-purple-600">On The Way!</span>
                            </h2>
                            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                                We're building powerful analytics tools to help you gain deeper insights into your feeding operations. 
                                Track consumption patterns, optimize costs, and make data-driven decisions.
                            </p>
                        </div>

                        <!-- Features Grid -->
                        <div class="mb-16">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                                Features You'll Love
                            </h3>
                            <div class="icon-grid stagger-animation">
                                @php
                                    $features = [
                                        ['icon' => 'chart-area', 'title' => 'Consumption Trends', 'color' => 'blue', 'desc' => 'Track feed usage patterns over time'],
                                        ['icon' => 'pie-chart', 'title' => 'Feed Distribution', 'color' => 'green', 'desc' => 'Monitor distribution across locations'],
                                        ['icon' => 'dollar-sign', 'title' => 'Cost Analysis', 'color' => 'purple', 'desc' => 'Optimize feeding costs & ROI'],
                                        ['icon' => 'calendar-check', 'title' => 'Schedule Tracking', 'color' => 'yellow', 'desc' => 'Monitor feeding schedules'],
                                        ['icon' => 'file-export', 'title' => 'Export Reports', 'color' => 'red', 'desc' => 'Generate detailed reports'],
                                        ['icon' => 'bell', 'title' => 'Smart Alerts', 'color' => 'indigo', 'desc' => 'Get notified of anomalies'],
                                    ];
                                @endphp
                                
                                @foreach($features as $feature)
                                <div class="text-center group">
                                    <div class="feature-icon bg-{{ $feature['color'] }}-50 text-{{ $feature['color'] }}-600 mx-auto mb-4 shadow-lg group-hover:shadow-2xl">
                                        <i class="fas fa-{{ $feature['icon'] }}"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $feature['desc'] }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Development Timeline -->
                        <div class="mb-12">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                                Development Timeline
                            </h3>
                            <div class="relative">
                                <!-- Timeline line -->
                                <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 h-full w-1 bg-gradient-to-b from-green-500 via-primary to-gray-300"></div>
                                
                                <div class="space-y-8 relative">
                                    @php
                                        $phases = [
                                            ['status' => 'completed', 'title' => 'Phase 1: Data Collection', 'desc' => 'Completed', 'icon' => 'check', 'date' => 'Q2 2024'],
                                            ['status' => 'in-progress', 'title' => 'Phase 2: Analytics Engine', 'desc' => 'In Business', 'icon' => 'spinner', 'date' => 'Q3 2024'],
                                            ['status' => 'pending', 'title' => 'Phase 3: UI Development', 'desc' => 'Coming Next', 'icon' => 'clock', 'date' => 'Q4 2024'],
                                        ];
                                    @endphp
                                    
                                    @foreach($phases as $phase)
                                    <div class="flex flex-col md:flex-row items-start {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                                        <div class="md:w-1/2 {{ $loop->iteration % 2 == 0 ? 'md:pr-12 md:text-right' : 'md:pl-12' }}">
                                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                                                <div class="flex items-center mb-3 {{ $loop->iteration % 2 == 0 ? 'md:justify-end' : '' }}">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-3
                                                        {{ $phase['status'] == 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                                        {{ $phase['status'] == 'in-progress' ? 'bg-primary/10 text-primary pulse-animation' : '' }}
                                                        {{ $phase['status'] == 'pending' ? 'bg-gray-100 text-gray-600' : '' }}">
                                                        <i class="fas fa-{{ $phase['icon'] }}"></i>
                                                    </div>
                                                    <h4 class="font-bold text-gray-900">{{ $phase['title'] }}</h4>
                                                </div>
                                                <p class="text-gray-600 {{ $loop->iteration % 2 == 0 ? 'md:text-right' : '' }}">{{ $phase['desc'] }}</p>
                                                <div class="mt-3 text-sm text-gray-500 {{ $loop->iteration % 2 == 0 ? 'md:text-right' : '' }}">
                                                    <i class="far fa-calendar mr-1"></i> {{ $phase['date'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 -translate-y-1/2">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center border-4 border-white shadow-lg
                                                {{ $phase['status'] == 'completed' ? 'bg-green-500' : '' }}
                                                {{ $phase['status'] == 'in-progress' ? 'bg-primary pulse-animation' : '' }}
                                                {{ $phase['status'] == 'pending' ? 'bg-gray-300' : '' }}">
                                                @if($phase['status'] == 'completed')
                                                <i class="fas fa-check text-white text-sm"></i>
                                                @elseif($phase['status'] == 'in-progress')
                                                <i class="fas fa-spinner fa-spin text-white text-sm"></i>
                                                @else
                                                <i class="fas fa-clock text-gray-600 text-sm"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-xl text-white bg-gradient-to-r from-primary to-purple-600 hover:from-primary/90 hover:to-purple-600/90 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                <i class="fas fa-arrow-left mr-3"></i>
                                Back to Dashboard
                            </a>
                            <a href="{{ route('admin.hardwareHistory') }}"
                                class="inline-flex items-center justify-center px-8 py-4 border-2 border-primary text-base font-semibold rounded-xl text-primary bg-white hover:bg-primary hover:text-white transform hover:-translate-y-1 transition-all duration-200">
                                <i class="fas fa-history mr-3"></i>
                                View Feeding History
                            </a>
                        </div>

                        <!-- Notification Signup -->
                        <div class="bg-gradient-to-r from-primary/5 to-purple-600/5 rounded-2xl p-8 border-2 border-primary/20">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                                    <i class="fas fa-bell text-primary text-2xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Get Notified When It's Ready</h3>
                                <p class="text-gray-600 mb-6 max-w-md">
                                    Want to be the first to know when analytics goes live? We'll send you an update!
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3 max-w-md w-full">
                                    <input type="email" placeholder="Enter your email address"
                                        class="flex-1 px-6 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent shadow-sm">
                                    <button
                                        class="px-8 py-3 bg-gradient-to-r from-primary to-purple-600 text-white rounded-xl hover:from-primary/90 hover:to-purple-600/90 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        Notify Me
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $infoCards = [
                        ['icon' => 'question-circle', 'title' => 'Need Help?', 'color' => 'blue', 
                         'desc' => 'Have questions about the upcoming analytics features?', 'link' => 'Contact Support'],
                        ['icon' => 'lightbulb', 'title' => 'Suggestions?', 'color' => 'green',
                         'desc' => 'We\'d love to hear what analytics features you need most.', 'link' => 'Share Feedback'],
                        ['icon' => 'book', 'title' => 'Documentation', 'color' => 'purple',
                         'desc' => 'Learn about current features and what\'s coming next.', 'link' => 'Read Docs'],
                    ];
                @endphp
                
                @foreach($infoCards as $card)
                <div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-{{ $card['color'] }}-500 transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-{{ $card['color'] }}-100 flex items-center justify-center mr-4">
                            <i class="fas fa-{{ $card['icon'] }} text-{{ $card['color'] }}-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $card['title'] }}</h3>
                            <p class="text-gray-600 mt-2">{{ $card['desc'] }}</p>
                        </div>
                    </div>
                    <a href="#"
                        class="inline-flex items-center text-sm font-semibold text-primary hover:text-secondary transition-colors duration-200 mt-4 group">
                        {{ $card['link'] }}
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-2 transition-transform duration-200"></i>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Progress Indicator -->
            <div class="mt-12 bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Overall Progress</h3>
                    <span class="text-2xl font-bold text-primary">65%</span>
                </div>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-4 mb-4 text-xs flex rounded-full bg-gray-200">
                        <div style="width: 65%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-primary to-purple-600 animate-pulse"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Data Collection</span>
                        <span>Analytics Engine</span>
                        <span>UI Development</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Email notification form handler
        document.querySelector('button').addEventListener('click', function() {
            const emailInput = document.querySelector('input[type="email"]');
            const email = emailInput.value;

            if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                // In production, this would send to your backend
                const successMsg = document.createElement('div');
                successMsg.className = 'mt-4 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 animate-fadeIn';
                successMsg.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-lg"></i>
                        <div>
                            <p class="font-semibold">Thank you! We'll notify you at ${email} when Analytics is ready.</p>
                            <p class="text-sm opacity-90 mt-1">You'll be the first to know about new features.</p>
                        </div>
                    </div>
                `;
                emailInput.parentNode.parentNode.appendChild(successMsg);
                emailInput.value = '';
                
                // Remove success message after 5 seconds
                setTimeout(() => successMsg.remove(), 5000);
            } else {
                emailInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                emailInput.focus();
                
                // Remove error class after 2 seconds
                setTimeout(() => {
                    emailInput.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                }, 2000);
            }
        });

        // Add animation to elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);

        // Observe all feature icons and cards
        document.querySelectorAll('.feature-icon, .info-card').forEach(el => {
            observer.observe(el);
        });
    </script>
@endsection