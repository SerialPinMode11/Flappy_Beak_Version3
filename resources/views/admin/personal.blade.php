@extends('layouts.self')
@section('title', 'Admin Personal')
@section('content')

    <div class="min-h-screen flex">

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-md p-4 flex justify-between items-center transition-bg">
                <h1 class="text-2xl font-semibold text-gray-800">Personal Profile</h1>
                <button id="darkModeToggle"
                    class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    <i class="fas fa-moon"></i>
                </button>
            </header>

            <div class="container mx-auto mt-8 p-4">
                <div class="bg-white shadow-lg rounded-lg p-6 mb-8 transition-bg">
                    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Admin User Details</h2>
                    <form id="adminForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="John Doe">
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" id="username" name="username"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="johndoe">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="john.doe@example.com">
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Business
                                    Location</label>
                                <input type="text" id="location" name="location"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="New York">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" id="password" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="********">
                            </div>
                            <div>
                                <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm
                                    Password</label>
                                <input type="password" id="confirm-password" name="confirm-password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-bg"
                                    value="********">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200">
                                Save Changes
                            </button>
                        </div>
                    </form>
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
            </div>
        </main>
    </div>
@endsection