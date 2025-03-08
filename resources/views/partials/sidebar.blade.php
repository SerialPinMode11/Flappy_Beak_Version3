<aside class="bg-gray-800 text-white w-64 min-h-screen hidden md:block">
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-xl font-bold text-[#ff6b6b]">Admin Dashboard</h2>
    </div>
    <nav class="p-4">
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-tachometer-alt mr-3"></i>Dashboard</a></li>
            <li><a href="{{ route('admin.product.index') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-box mr-3"></i>Product Stocks</a></li>
            <li><a href="{{ route('admin.billing.index') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-dollar-sign mr-3"></i>Income Generated</a></li>
            <li><a href="" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-table mr-3"></i>Expenses Table</a></li>
            <li><a href="" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-industry mr-3"></i>Client Placeholder</a></li>
            <li class="relative group">
                <button class="flex items-center w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-user mr-3"></i>Customer Management<i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <ul class="hidden group-hover:block absolute left-full top-0 ml-2 w-48 bg-gray-700 rounded-lg shadow-lg">
                    <li><a href="" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600">Order Management</a></li>
                    <li><a href="" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600">Feedback Cards</a></li>
                </ul>
            </li>
            <li><a href="" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-desktop mr-3"></i>Hardware</a></li>
            <li><a href="" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"><i class="fas fa-user-circle mr-3"></i>Personal</a></li>

            <!-- 🛑 Fix Logout Button (Using Form) -->
            <li>
                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
