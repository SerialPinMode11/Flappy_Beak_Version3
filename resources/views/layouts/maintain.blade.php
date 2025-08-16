<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flappy-Beak Login') - Flappy-Beak Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B6B',
                        secondary: '#4ECDC4',
                        accent: '#45B7D1',
                        neutral: '#2C3E50',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .auth-container {
            min-height: calc(100vh - 76px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF6B6B, #4ECDC4);
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-primary">JM Casabar Pekin Store</h1>
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-neutral hover:text-primary transition-colors">Home</a>
                    <a href="" class="text-neutral hover:text-primary transition-colors">Contact</a>
                    <a href="" class="text-neutral hover:text-primary transition-colors">About</a>
                    <a href="" class="text-primary font-semibold hover:text-accent transition-colors">Sign Up</a>
                </nav>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                     <img src="{{ asset('images/Flappy_IoT.png') }}" alt="Flappy IoT Logo" class="w-8 h-8">
                    <button class="text-neutral hover:text-primary transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <button class="text-neutral hover:text-primary transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="auth-container flex items-center justify-center py-12 px-4">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4 text-center space-y-6">
            <!-- Footer Brand/Info -->
            <p class="text-lg font-semibold">&copy; 2025 Exclusive. All rights reserved.</p>
            
            <!-- Quote Section -->
            <div class="max-w-2xl mx-auto border-2 border-gray-700 rounded-lg p-6 shadow-md bg-gray-900">
                <p class="text-center text-gray-300 italic">
                    "From farm to table, savor the rich flavors of Pekin duck—where every bite tells a story of quality and care."
                </p>
            </div>
            
            <!-- Social Media Icons -->
            <div class="flex justify-center space-x-6">
                <!-- Facebook -->
                <a href="https://web.facebook.com/IMORTALxiiJERRY" class="text-gray-400 hover:text-white transition-colors" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.351C0 23.4.6 24 1.325 
                        24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.893-4.788 4.657-4.788 
                        1.325 0 2.464.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 
                        1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.4 24 24 23.4 24 
                        22.675V1.325C24 .6 23.4 0 22.675 0z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com/jerry_casabar?igsh=Y2x6enlmdHB3cmhq" class="text-gray-400 hover:text-white transition-colors" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.35 
                        3.608 1.325.975.975 1.262 2.242 1.324 3.608.058 1.266.07 
                        1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.35 2.633-1.324 
                        3.608-.975.975-2.242 1.262-3.608 1.324-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.35-3.608-1.324-.975-.975-1.262-2.242-1.324-3.608C2.175 
                        15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85c.062-1.366.35-2.633 
                        1.324-3.608.975-.975 2.242-1.262 3.608-1.324C8.416 2.175 8.796 2.163 
                        12 2.163zm0 1.837c-3.16 0-3.517.012-4.75.069-1.02.047-1.577.217-1.945.363-.49.19-.84.418-1.207.785-.367.367-.595.717-.785 
                        1.207-.146.368-.316.925-.363 1.945-.057 1.233-.069 1.59-.069 
                        4.75s.012 3.517.069 4.75c.047 1.02.217 1.577.363 
                        1.945.19.49.418.84.785 1.207.367.367.717.595 1.207.785.368.146.925.316 
                        1.945.363 1.233.057 1.59.069 4.75.069s3.517-.012 
                        4.75-.069c1.02-.047 1.577-.217 1.945-.363.49-.19.84-.418 
                        1.207-.785.367-.367.595-.717.785-1.207.146-.368.316-.925.363-1.945.057-1.233.069-1.59.069-4.75s-.012-3.517-.069-4.75c-.047-1.02-.217-1.577-.363-1.945-.19-.49-.418-.84-.785-1.207-.367-.367-.717-.595-1.207-.785-.368-.146-.925-.316-1.945-.363-1.233-.057-1.59-.069-4.75-.069zm0 
                        3.895a5.943 5.943 0 1 0 0 11.886 5.943 5.943 0 0 0 0-11.886zm0 
                        9.8a3.857 3.857 0 1 1 0-7.714 3.857 3.857 0 0 1 0 7.714zm6.406-10.845a1.386 1.386 0 1 1 0-2.772 1.386 1.386 0 0 1 0 2.772z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
    
</body>
</html>