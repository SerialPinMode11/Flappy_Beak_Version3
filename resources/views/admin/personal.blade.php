@extends('layouts.self')
@section('title', 'Admin Personal')
@section('content')


    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Admin Credentials Information</h1>
            <div class="flex items-center space-x-4">

                
                <a href="{{ route('admin.personal.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus mr-2"></i> Add New Admin User
                </a>
                <div class="relative">
                    <input type="search" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="relative">
                    <i class="fas fa-bell text-gray-600 text-xl"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">

                    <span class="font-medium">Personal Data</span>
                </button>
            </div>
        </div>
        </header>


        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->role ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.personal.destroy', ['id' => $user->id]) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this admin user?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No admin users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 transition-bg">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Admin Privileges</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 shadow transition-bg">
                    <h3 class="text-lg font-medium mb-2 text-gray-800">Expenses Report</h3>
                    <p class="text-gray-600 mb-2">
                        Generate a comprehensive expenses report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateReport"
                        class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Expenses Report
                    </button>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 shadow transition-bg">
                    <h3 class="text-lg font-medium mb-2 text-gray-800">Sales Report</h3>
                    <p class="text-gray-600 mb-2">
                        Generate a comprehensive sales report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateReport"
                        class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Sales Report
                    </button>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 shadow transition-bg">
                    <h3 class="text-lg font-medium mb-2 text-gray-800">Income Report</h3>
                    <p class="text-gray-600 mb-2">
                        Generate a comprehensive income report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateReport"
                        class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Income Report
                    </button>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 shadow transition-bg">
                    <h3 class="text-lg font-medium mb-2 text-gray-800">Product Stock Report</h3>
                    <p class="text-gray-600 mb-2">
                        Generate a comprehensive stock report in MS Excel format for detailed analysis and
                        record-keeping.
                    </p>
                    <button id="generateReport"
                        class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                        Generate Stock Report
                    </button>
                </div>
            </div>
        </div>

    </main>

@endsection

