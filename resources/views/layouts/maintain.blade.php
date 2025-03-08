<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Exclusive') - Exclusive</title>
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
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.54 6.42a8.44 8.44 0 0 1-2.43.67 4.21 4.21 0 0 0 1.85-2.31 8.42 8.42 0 0 1-2.67 1.02A4.2 4.2 0 0 0 16.29 4c-2.35 0-4.26 1.9-4.26 4.26 0 .33.04.65.1.96A12 12 0 0 1 3 5.13a4.23 4.23 0 0 0-.58 2.15c0 1.47.75 2.77 1.89 3.54a4.19 4.19 0 0 1-1.93-.54v.06c0 2.05 1.46 3.76 3.4 4.15a4.2 4.2 0 0 1-1.92.07c.54 1.68 2.1 2.91 3.96 2.94A8.42 8.42 0 0 1 2 19.74a11.88 11.88 0 0 0 6.29 1.84c7.54 0 11.67-6.25 11.67-11.67 0-.18 0-.35-.01-.52a8.33 8.33 0 0 0 2.06-2.13z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 2.41c-1 .44-2.07.73-3.2.87a5.44 5.44 0 0 0 2.39-3 10.84 10.84 0 0 1-3.43 1.31A5.41 5.41 0 0 0 11.28 6a4.89 4.89 0 0 0 .13 1.23A15.31 15.31 0 0 1 2 4.15a5.47 5.47 0 0 0 .82 2.91 5.29 5.29 0 0 0 4.11 2.12A5.3 5.3 0 0 1 3 8v.06c.05 2.35 1.7 4.3 4 4.75a5.29 5.29 0 0 1-2.4.09c.68 2.1 2.65 3.63 5 3.68a10.83 10.83 0 0 1-6.68 2.3A10.7 10.7 0 0 1 0 20.53a15.3 15.3 0 0 0 8.29 2.44C19.13 23 24 14.88 24 8.75a12 12 0 0 0-.27-2.34A8.57 8.57 0 0 0 24 4.35c-1 .44-2.07.73-3.2.87A5.44 5.44 0 0 0 22 2.41z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
    
</body>
</html>