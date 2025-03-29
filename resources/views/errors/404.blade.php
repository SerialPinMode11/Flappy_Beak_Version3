<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Flappy Beak</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        @keyframes search {
            0% { transform: translateX(0) rotate(0deg); }
            25% { transform: translateX(15px) rotate(5deg); }
            50% { transform: translateX(0) rotate(0deg); }
            75% { transform: translateX(-15px) rotate(-5deg); }
            100% { transform: translateX(0) rotate(0deg); }
        }
        
        .duck-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .duck-search {
            animation: search 3s ease-in-out infinite;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(59, 130, 246, 0.3);
            transform: scale(0);
            animation: ripple 2s linear infinite;
        }
        
        @keyframes ripple {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }
    </style>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full text-center">
        <div class="relative mb-8 inline-block">
            <!-- Water ripples -->
            <div class="ripple w-32 h-32 left-1/2 bottom-0 -ml-16"></div>
            <div class="ripple w-48 h-48 left-1/2 bottom-0 -ml-24" style="animation-delay: 0.5s"></div>
            
            <!-- Duck animation -->
            <div class="duck-float relative">
                <div class="duck-search">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-40 h-40">
                        <!-- Duck body -->
                        <path fill="#FFD54F" d="M400,160c0,53.02-42.98,96-96,96s-96-42.98-96-96s42.98-96,96-96S400,106.98,400,160z"/>
                        <!-- Duck head -->
                        <path fill="#FFB300" d="M304,64c-35.35,0-64,28.65-64,64c0,35.35,28.65,64,64,64s64-28.65,64-64C368,92.65,339.35,64,304,64z"/>
                        <!-- Duck bill -->
                        <path fill="#FF9800" d="M304,160c-17.67,0-32-14.33-32-32s14.33-32,32-32s32,14.33,32,32S321.67,160,304,160z"/>
                        <!-- Duck eye -->
                        <circle fill="#212121" cx="320" cy="112" r="8"/>
                        <!-- Magnifying glass -->
                        <circle fill="none" stroke="#546E7A" stroke-width="8" cx="240" cy="200" r="24"/>
                        <path fill="none" stroke="#546E7A" stroke-width="8" d="M256,216l16,16"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <h1 class="text-5xl font-bold text-blue-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-blue-600 mb-6">Quack! Page Not Found</h2>
        <p class="text-gray-600 mb-8">Our duck detective couldn't find the page you're looking for. It seems to have waddled away!</p>
        
        <a href="{{ url('login') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:-rotate-2">
            Waddle Back Home
        </a>
    </div>
    
    <script>
        // Add some random floating bubbles
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('body');
            
            for (let i = 0; i < 10; i++) {
                createBubble(container);
            }
            
            function createBubble(parent) {
                const bubble = document.createElement('div');
                const size = Math.random() * 20 + 10;
                const duration = Math.random() * 10 + 5;
                const delay = Math.random() * 5;
                
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${Math.random() * 100}%`;
                bubble.style.bottom = '0';
                bubble.style.position = 'absolute';
                bubble.style.borderRadius = '50%';
                bubble.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                bubble.style.animation = `float ${duration}s ease-in-out ${delay}s infinite`;
                bubble.style.zIndex = '-1';
                
                parent.appendChild(bubble);
            }
        });
    </script>
</body>
</html>

