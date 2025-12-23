@extends('layouts.static')

@section('title', 'Manage Incubation Bookings')

@section('content')
<!-- Added internal CSS with design tokens and custom properties -->
<style>
:root {
  /* Color Palette */
  --color-primary: #1f2937;
  --color-primary-foreground: #ffffff;
  --color-secondary: #f3f4f6;
  --color-secondary-foreground: #1f2937;
  --color-accent: #8b5cf6;
  --color-accent-foreground: #ffffff;
  --color-muted: #f9fafb;
  --color-muted-foreground: #6b7280;
  --color-card: #ffffff;
  --color-card-foreground: #1f2937;
  --color-background: #f8fafc;
  --color-foreground: #1f2937;
  --color-border: #e5e7eb;
  --color-input: #ffffff;
  --color-ring: #8b5cf6;
  --color-destructive: #ef4444;
  --color-chart-1: #f59e0b;
  --color-chart-2: #10b981;
  --color-chart-3: #3b82f6;
  --color-chart-4: #8b5cf6;
}

/* Custom Tailwind utilities */
.bg-primary { background-color: var(--color-primary); }
.text-primary-foreground { color: var(--color-primary-foreground); }
.bg-secondary { background-color: var(--color-secondary); }
.text-secondary-foreground { color: var(--color-secondary-foreground); }
.bg-accent { background-color: var(--color-accent); }
.text-accent-foreground { color: var(--color-accent-foreground); }
.bg-accent\/10 { background-color: rgb(139 92 246 / 0.1); }
.text-accent { color: var(--color-accent); }
.bg-accent\/20 { background-color: rgb(139 92 246 / 0.2); }
.bg-muted { background-color: var(--color-muted); }
.text-muted-foreground { color: var(--color-muted-foreground); }
.bg-muted\/50 { background-color: rgb(249 250 251 / 0.5); }
.bg-card { background-color: var(--color-card); }
.text-card-foreground { color: var(--color-card-foreground); }
.bg-background { background-color: var(--color-background); }
.text-foreground { color: var(--color-foreground); }
.border-border { border-color: var(--color-border); }
.bg-input { background-color: var(--color-input); }
.focus\:ring-ring:focus { --tw-ring-color: var(--color-ring); }
.text-destructive { color: var(--color-destructive); }
.bg-destructive\/10 { background-color: rgb(239 68 68 / 0.1); }

/* Chart colors */
.bg-chart-1\/10 { background-color: rgb(245 158 11 / 0.1); }
.text-chart-1 { color: var(--color-chart-1); }
.bg-chart-2\/10 { background-color: rgb(16 185 129 / 0.1); }
.text-chart-2 { color: var(--color-chart-2); }
.bg-chart-2\/20 { background-color: rgb(16 185 129 / 0.2); }
.bg-chart-3\/10 { background-color: rgb(59 130 246 / 0.1); }
.text-chart-3 { color: var(--color-chart-3); }
.bg-chart-4\/10 { background-color: rgb(139 92 246 / 0.1); }
.text-chart-4 { color: var(--color-chart-4); }
.bg-chart-4\/20 { background-color: rgb(139 92 246 / 0.2); }

/* Hover effects */
.hover\:bg-accent\/90:hover { background-color: rgb(139 92 246 / 0.9); }
.hover\:bg-primary\/90:hover { background-color: rgb(31 41 55 / 0.9); }
.hover\:text-card-foreground:hover { color: var(--color-card-foreground); }

/* Focus effects */
.focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus\:border-transparent:focus { border-color: transparent; }

/* Print-specific CSS styles */
@media print {
    /* Hide everything by default */
    body * { visibility: hidden; }
    
    /* Show only printable content */
    .printable-area, .printable-area * { visibility: visible; }
    .printable-area { position: absolute; left: 0; top: 0; width: 100%; }
    
    /* Hide all dashboard cards, filters, and UI elements from print */
    .no-print { display: none !important; }
    .status-column { display: none !important; }
    .action-column { display: none !important; }
    
    /* Hide dashboard cards completely */
    .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4.gap-6.mb-8 { display: none !important; }
    
    /* Hide filter section completely */
    .bg-card.rounded-xl.border.border-border.mb-8 { display: none !important; }
    
    /* Hide header section */
    .bg-primary.border-b.border-border { display: none !important; }
    
    /* Hide pagination */
    .px-6.py-4.border-t.border-border.no-print { display: none !important; }
    
    /* Hide table header with "All Bookings" */
    .px-6.py-4.border-b.border-border.flex.items-center.justify-between.no-print { display: none !important; }
    
    /* Show print header */
    .print-header { 
        display: block !important; 
        margin-bottom: 20px;
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        page-break-inside: avoid;
    }
    
    /* Style the table container for print only */
    .bg-card.rounded-xl.border.border-border:last-child { 
        display: block !important; 
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        background: white !important;
    }
    
    /* Optimize table for printing */
    table { 
        width: 100% !important; 
        border-collapse: collapse !important;
        font-size: 10px !important;
        margin: 0 !important;
    }
    
    th, td { 
        border: 1px solid #000 !important; 
        padding: 4px !important;
        text-align: left !important;
        font-size: 9px !important;
    }
    
    th { 
        background-color: #f0f0f0 !important; 
        font-weight: bold !important;
    }
    
    /* Show print summary with totals */
    .print-summary {
        display: block !important;
        margin-top: 20px;
        border-top: 2px solid #000;
        padding-top: 15px;
        text-align: center;
        page-break-inside: avoid;
    }
    
    @page { 
        size: landscape; 
        margin: 0.5in; 
    }
}
</style>

<div class="min-h-screen bg-background">
    <!-- Updated header with modern Tailwind styling and semantic tokens -->
    <div class="bg-primary border-b border-border no-print" style="background-color: #f0f0f0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-primary-foreground" style="color: #000">Incubation Management</h1>
                </div>
                <!-- Replaced CSV export with Excel export and added print functionality -->
                <div class="flex items-center space-x-3">
                    <!-- Added month/year picker for filtering print results -->
                    <div class="no-print">
                        <input type="month" id="printMonth" class="px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground text-sm" value="">
                    </div>
                    
                    <!-- Person selection for printing -->
                    <div class="no-print">
                        <select id="printPerson" class="px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground text-sm">
                            <option value="JERRY M. CASABAR">JERRY M. CASABAR</option>
                            <option value="MYRNA TUDAYAN PASCUA">MYRNA TUDAYAN PASCUA</option>
                        </select>
                    </div>
                    
                    <!-- Print Button -->
                    <button onclick="printTable()" class="no-print inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </button>
                    
                    <!-- Excel Export Button -->
                    <button onclick="openExportModal()" class="no-print inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generate Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated print header to match the professional format shown in the image -->
    <div class="print-header" style="display: none;">
        <h1 style="font-size: 20px; margin: 0 0 15px 0; font-weight: bold; text-align: center;">Flappy-Beak Income Generated Report in Incubation Booking</h1>
        <p style="margin: 5px 0; font-size: 12px; text-align: center;">Date Printed: <span id="printDate"></span></p>
        <p style="margin: 5px 0; font-size: 12px; text-align: center;">Printed by: <span id="printPersonName"></span></p>
        <p style="margin: 5px 0 15px 0; font-size: 12px; text-align: center;">Report Type: Complete Income Records Only</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 printable-area">
        <!-- Redesigned dashboard cards with modern styling and semantic tokens -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 no-print">
            <div class="bg-card rounded-xl border border-border p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wide">Total Bookings</p>
                        <p class="text-3xl font-bold text-card-foreground mt-2">{{ $counts['total'] }}</p>
                    </div>
                    <div class="p-3 bg-chart-4/10 rounded-lg">
                        <svg class="w-6 h-6 text-chart-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-xl border border-border p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wide">Pending Bookings</p>
                        <p class="text-3xl font-bold text-card-foreground mt-2">{{ $counts['pending'] }}</p>
                    </div>
                    <div class="p-3 bg-chart-1/10 rounded-lg">
                        <svg class="w-6 h-6 text-chart-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-xl border border-border p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wide">Active Incubations</p>
                        <p class="text-3xl font-bold text-card-foreground mt-2">{{ $counts['active'] }}</p>
                    </div>
                    <div class="p-3 bg-chart-2/10 rounded-lg">
                        <svg class="w-6 h-6 text-chart-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-xl border border-border p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wide">Completed</p>
                        <p class="text-3xl font-bold text-card-foreground mt-2">{{ $counts['completed'] }}</p>
                    </div>
                    <div class="p-3 bg-chart-3/10 rounded-lg">
                        <svg class="w-6 h-6 text-chart-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern filter section with improved styling -->
        <div class="bg-card rounded-xl border border-border mb-8 no-print">
            <div class="px-6 py-4 border-b border-border">
                <h3 class="text-lg font-semibold text-card-foreground">Filter Bookings</h3>
            </div>
            <div class="p-6">
                <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div class="space-y-2">
                        <label for="status" class="text-sm font-medium text-card-foreground">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="service_type" class="text-sm font-medium text-card-foreground">Service Type</label>
                        <select name="service_type" id="service_type" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                            <option value="">All Types</option>
                            @foreach($serviceTypes as $value => $label)
                                <option value="{{ $value }}" {{ request('service_type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="date_from" class="text-sm font-medium text-card-foreground">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="space-y-2">
                        <label for="date_to" class="text-sm font-medium text-card-foreground">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ request('date_to') }}">
                    </div>
                    
                    <div class="space-y-2">
                        <label for="search" class="text-sm font-medium text-card-foreground">Search</label>
                        <input type="text" name="search" id="search" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" placeholder="Name, Email, Reference..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modern table design with improved styling and semantic tokens -->
        <div class="bg-card rounded-xl border border-border">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between no-print">
                <h3 class="text-lg font-semibold text-card-foreground">All Bookings</h3>
                <span class="text-sm text-muted-foreground">
                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} bookings
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Service</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Eggs</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Total Price</th>
                            <!-- Added status-column class to hide in print -->
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider status-column">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Created</th>
                            <!-- Added action-column class to hide in print -->
                            <th class="px-6 py-4 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-muted/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-card-foreground">
                                    {{ $booking->booking_reference }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-card-foreground">{{ $booking->name }}</div>
                                    <div class="text-sm text-muted-foreground">{{ $booking->email }}</div>
                                    <div class="text-sm text-muted-foreground">{{ $booking->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $serviceColors = [
                                            'jm_casabar' => 'bg-chart-4/10 text-chart-4',
                                            'custom' => 'bg-chart-2/10 text-chart-2',
                                            'experimental' => 'bg-chart-1/10 text-chart-1',
                                            'world_based' => 'bg-chart-3/10 text-chart-3',
                                        ];
                                        $color = $serviceColors[$booking->service_type] ?? 'bg-muted text-muted-foreground';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $booking->service_type_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-card-foreground">
                                    {{ $booking->egg_quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-card-foreground">
                                    {{ $booking->start_date ? $booking->start_date->format('M d, Y') : 'Not set' }}
                                </td>
                                <!-- Added total price column -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-card-foreground">
                                    ₱{{ number_format($booking->total_price, 2) }}
                                </td>
                                <!-- Added status-column class to hide in print -->
                                <td class="px-6 py-4 whitespace-nowrap status-column">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-chart-1/10 text-chart-1',
                                            'confirmed' => 'bg-chart-2/10 text-chart-2',
                                            'in_progress' => 'bg-chart-4/10 text-chart-4',
                                            'candling' => 'bg-chart-4/10 text-chart-4',
                                            'lockdown' => 'bg-chart-4/10 text-chart-4',
                                            'hatching' => 'bg-chart-2/10 text-chart-2',
                                            'completed' => 'bg-chart-3/10 text-chart-3',
                                            'cancelled' => 'bg-destructive/10 text-destructive',
                                        ];
                                        $statusColor = $statusColors[$booking->status] ?? 'bg-muted text-muted-foreground';
                                    @endphp
                                    <div class="flex flex-col space-y-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ $booking->status_name }}
                                        </span>
                                        
                                        @if($booking->deposit_paid)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-chart-3/10 text-chart-3">
                                                Deposit Paid
                                            </span>
                                        @endif
                                        
                                        @if($booking->balance_paid)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-chart-3/10 text-chart-3">
                                                Fully Paid
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-card-foreground">
                                    {{ $booking->created_at->format('M d, Y') }}
                                </td>
                                <!-- Added action-column class to hide in print -->
                                <td class="px-6 py-4 whitespace-nowrap action-column">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center p-2 bg-chart-4/10 text-chart-4 rounded-lg hover:bg-chart-4/20 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="inline-flex items-center p-2 bg-chart-2/10 text-chart-2 rounded-lg hover:bg-chart-2/20 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" class="inline-flex items-center p-2 bg-accent/10 text-accent rounded-lg hover:bg-accent/20 transition-colors duration-200" onclick="openStatusModal('{{ $booking->id }}')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Modern modal design with Tailwind styling -->
                                    <div id="statusModal{{ $booking->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                                        <div class="bg-card rounded-xl max-w-md w-full mx-4 shadow-xl">
                                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="px-6 py-4 border-b border-border">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-lg font-semibold text-card-foreground">Update Status</h3>
                                                        <button type="button" class="text-muted-foreground hover:text-card-foreground" onclick="closeStatusModal('{{ $booking->id }}')">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="p-6 space-y-4">
                                                    <div class="space-y-2">
                                                        <label for="status{{ $booking->id }}" class="text-sm font-medium text-card-foreground">Status</label>
                                                        <select name="status" id="status{{ $booking->id }}" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" required>
                                                            @foreach($statuses as $value => $label)
                                                                <option value="{{ $value }}" {{ $booking->status == $value ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <label for="status_notes{{ $booking->id }}" class="text-sm font-medium text-card-foreground">Notes</label>
                                                        <textarea name="status_notes" id="status_notes{{ $booking->id }}" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="px-6 py-4 border-t border-border flex items-center justify-end space-x-3">
                                                    <button type="button" class="px-4 py-2 text-muted-foreground hover:text-card-foreground transition-colors duration-200" onclick="closeStatusModal('{{ $booking->id }}')">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium">
                                                        Update Status
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <!-- Updated colspan to match visible columns in print -->
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-muted-foreground">No bookings found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Enhanced print summary section to show total at bottom of table -->
            <div class="print-summary" style="display: none;">
                <div style="border-top: 2px solid #000; padding-top: 15px; margin-top: 20px; text-align: right;">
                    <p style="margin: 5px 0; font-size: 12px; font-weight: bold;">Total Completed Income: ₱<span id="totalIncome"></span></p>
                </div>
            </div>
            
            <!-- Modern pagination styling -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-border no-print">
                    <div class="flex items-center justify-center">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Added Export Modal -->
<div id="exportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-card rounded-xl max-w-md w-full mx-4 shadow-xl">
        <form action="{{ route('admin.incubation.export') }}" method="GET">
            <div class="px-6 py-4 border-b border-border">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-card-foreground">Export Incubation Report</h3>
                    <button type="button" class="text-muted-foreground hover:text-card-foreground" onclick="closeExportModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="export_date_from" class="text-sm font-medium text-card-foreground">Date From</label>
                        <input type="date" name="date_from" id="export_date_from" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                    </div>
                    <div class="space-y-2">
                        <label for="export_date_to" class="text-sm font-medium text-card-foreground">Date To</label>
                        <input type="date" name="date_to" id="export_date_to" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="export_service_type" class="text-sm font-medium text-card-foreground">Service Type</label>
                    <select name="service_type" id="export_service_type" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                        <option value="">All Service Types</option>
                        @foreach($serviceTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-border flex items-center justify-end space-x-3">
                <button type="button" class="px-4 py-2 text-muted-foreground hover:text-card-foreground transition-colors duration-200" onclick="closeExportModal()">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                    Generate Excel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatusModal(bookingId) {
    document.getElementById('statusModal' + bookingId).classList.remove('hidden');
    document.getElementById('statusModal' + bookingId).classList.add('flex');
}

function closeStatusModal(bookingId) {
    document.getElementById('statusModal' + bookingId).classList.add('hidden');
    document.getElementById('statusModal' + bookingId).classList.remove('flex');
}

function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
    document.getElementById('exportModal').classList.add('flex');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
    document.getElementById('exportModal').classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('printMonth').value = `${year}-${month}`;
});

function printTable() {
    const now = new Date();
    const printDate = now.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    }) + ' at ' + now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
    const selectedPerson = document.getElementById('printPerson').value;
    const selectedMonth = document.getElementById('printMonth').value;
    
    // Parse the selected month
    const [year, month] = selectedMonth.split('-');
    const monthName = new Date(year, month - 1).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    
    // Filter bookings by selected month and completed status
    const rows = document.querySelectorAll('tbody tr');
    let filteredBookings = [];
    let totalIncome = 0;
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 7) {
            const statusCell = cells[6];
            const createdDateCell = cells[7];
            const priceCell = cells[5];
            
            // Check if status is completed
            const statusSpans = statusCell.querySelectorAll('span');
            let isCompleted = false;
            statusSpans.forEach(span => {
                if (span.textContent.toLowerCase().includes('completed')) {
                    isCompleted = true;
                }
            });
            
            if (isCompleted && createdDateCell && priceCell) {
                // Parse date and check if it matches selected month
                const dateText = createdDateCell.textContent.trim();
                const bookingDate = new Date(dateText);
                const bookingMonth = String(bookingDate.getMonth() + 1).padStart(2, '0');
                const bookingYear = bookingDate.getFullYear();
                
                if (`${bookingYear}-${bookingMonth}` === selectedMonth) {
                    // Extract booking details
                    const reference = cells[0].textContent.trim();
                    const customerName = cells[1].querySelector('.text-sm.font-medium')?.textContent.trim() || '';
                    const customerEmail = cells[1].querySelectorAll('.text-sm.text-muted-foreground')[0]?.textContent.trim() || '';
                    const service = cells[2].textContent.trim();
                    const eggs = cells[3].textContent.trim();
                    const price = parseFloat(priceCell.textContent.trim().replace('₱', '').replace(/,/g, ''));
                    const date = dateText;
                    
                    if (!isNaN(price)) {
                        filteredBookings.push({
                            reference,
                            customerName,
                            customerEmail,
                            service,
                            eggs,
                            price,
                            date
                        });
                        totalIncome += price;
                    }
                }
            }
        }
    });
    
    // Create receipt content
    let receiptHTML = `
        <div style="font-family: 'Courier New', monospace; max-width: 600px; margin: 0 auto; padding: 20px; line-height: 1.6;">
            <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px;">
                <h1 style="font-size: 22px; margin: 0 0 10px 0; font-weight: bold; letter-spacing: 2px;">FLAPPY-BEAK</h1>
                <h2 style="font-size: 16px; margin: 0 0 10px 0;">INCUBATION SERVICE REVENUE REPORT</h2>
                <p style="margin: 5px 0; font-size: 13px;">Report Period: ${monthName}</p>
                <p style="margin: 5px 0; font-size: 12px;">Date Printed: ${printDate}</p>
                <p style="margin: 5px 0; font-size: 12px;">Printed by: ${selectedPerson}</p>
                <p style="margin: 5px 0; font-size: 11px; font-style: italic;">Status: Completed Bookings Only</p>
            </div>
            
            <div style="margin-bottom: 20px;">
    `;
    
    if (filteredBookings.length === 0) {
        receiptHTML += `
            <div style="text-align: center; padding: 40px 20px; border: 2px dashed #999;">
                <p style="font-size: 14px; color: #666;">No completed bookings found for ${monthName}</p>
            </div>
        `;
    } else {
        filteredBookings.forEach((booking, index) => {
            receiptHTML += `
                <div style="border-bottom: 1px dashed #666; padding: 15px 0; page-break-inside: avoid;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold; font-size: 13px;">TRANSACTION #${index + 1}</span>
                        <span style="font-size: 12px;">${booking.date}</span>
                    </div>
                    <div style="margin-bottom: 3px;">
                        <span style="font-size: 11px; color: #555;">REF:</span>
                        <span style="font-size: 12px; margin-left: 5px;">${booking.reference}</span>
                    </div>
                    <div style="margin-bottom: 3px;">
                        <span style="font-size: 11px; color: #555;">CUSTOMER:</span>
                        <span style="font-size: 12px; margin-left: 5px;">${booking.customerName}</span>
                    </div>
                    <div style="margin-bottom: 3px;">
                        <span style="font-size: 11px; color: #555;">EMAIL:</span>
                        <span style="font-size: 12px; margin-left: 5px;">${booking.customerEmail}</span>
                    </div>
                    <div style="margin-bottom: 3px;">
                        <span style="font-size: 11px; color: #555;">SERVICE:</span>
                        <span style="font-size: 12px; margin-left: 5px;">${booking.service}</span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <span style="font-size: 11px; color: #555;">EGGS QTY:</span>
                        <span style="font-size: 12px; margin-left: 5px;">${booking.eggs}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 14px; padding-top: 5px; border-top: 1px solid #999;">
                        <span>AMOUNT:</span>
                        <span>₱${booking.price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                    </div>
                </div>
            `;
        });
        
        receiptHTML += `
            <div style="margin-top: 25px; padding-top: 15px; border-top: 2px solid #000;">
                <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                    <span style="font-weight: bold;">TOTAL TRANSACTIONS:</span>
                    <span>${filteredBookings.length}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; padding: 10px; background-color: #f0f0f0;">
                    <span>GRAND TOTAL:</span>
                    <span>₱${totalIncome.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                </div>
            </div>
        `;
    }
    
    receiptHTML += `
            </div>
            
            <div style="text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px dashed #999; font-size: 11px; color: #666;">
                <p style="margin: 5px 0;">Thank you for your business!</p>
                <p style="margin: 5px 0;">This is a computer-generated report</p>
            </div>
        </div>
    `;
    
    // Create a new window for printing
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Flappy-Beak Incubation Revenue Report - ${monthName}</title>
            <style>
                @page {
                    size: A4;
                    margin: 0.5in;
                }
                body {
                    margin: 0;
                    padding: 0;
                    font-family: 'Courier New', monospace;
                }
                @media print {
                    body {
                        print-color-adjust: exact;
                        -webkit-print-color-adjust: exact;
                    }
                }
            </style>
        </head>
        <body>
            ${receiptHTML}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    
    // Wait for content to load before printing
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}
</script>
@endsection
