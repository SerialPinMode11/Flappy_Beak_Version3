@extends('layouts.static')

@section('title', 'Edit Incubation Booking')

@section('content')
<!-- Internal CSS with design tokens -->
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
  --color-success: #10b981;
  --color-warning: #f59e0b;
}

/* Custom Tailwind utilities */
.bg-primary { background-color: var(--color-primary); }
.text-primary-foreground { color: var(--color-primary-foreground); }
.bg-secondary { background-color: var(--color-secondary); }
.text-secondary-foreground { color: var(--color-secondary-foreground); }
.bg-accent { background-color: var(--color-accent); }
.text-accent-foreground { color: var(--color-accent-foreground); }
.bg-muted { background-color: var(--color-muted); }
.text-muted-foreground { color: var(--color-muted-foreground); }
.bg-card { background-color: var(--color-card); }
.text-card-foreground { color: var(--color-card-foreground); }
.bg-background { background-color: var(--color-background); }
.text-foreground { color: var(--color-foreground); }
.border-border { border-color: var(--color-border); }
.bg-input { background-color: var(--color-input); }
.focus\:ring-ring:focus { --tw-ring-color: var(--color-ring); }
.text-destructive { color: var(--color-destructive); }
.text-success { color: var(--color-success); }
.text-warning { color: var(--color-warning); }
.bg-success\/10 { background-color: rgb(16 185 129 / 0.1); }
.bg-warning\/10 { background-color: rgb(245 158 11 / 0.1); }
.hover\:bg-accent\/90:hover { background-color: rgb(139 92 246 / 0.9); }
.hover\:bg-primary\/90:hover { background-color: rgb(31 41 55 / 0.9); }
.focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus\:border-transparent:focus { border-color: transparent; }
</style>

<div class="min-h-screen bg-background">
    <!-- Header -->
    <div class="bg-primary border-b border-border" style="background-color: white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.incubation.index') }}" class="text-accent hover:text-accent/80">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-primary-foreground" style="color: black">Edit Incubation Booking</h1>
                    <span class="px-3 py-1 bg-accent/10 text-accent rounded-full text-sm font-medium">
                        {{ $booking->booking_reference }}
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 bg-secondary text-secondary-foreground rounded-lg hover:bg-secondary/80 transition-colors duration-200">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-success/10 border border-success/20 rounded-lg">
                <p class="text-success font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-destructive/10 border border-destructive/20 rounded-lg">
                <ul class="text-destructive space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Progress Overview -->
        <div class="mb-8 bg-card rounded-xl border border-border p-6">
            <h3 class="text-lg font-semibold text-card-foreground mb-4">Incubation Progress</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent">{{ $booking->progress_percent }}%</div>
                    <div class="text-sm text-muted-foreground">Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-card-foreground">{{ $booking->current_phase }}</div>
                    <div class="text-sm text-muted-foreground">Current Phase</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-warning">{{ $booking->egg_quantity }}</div>
                    <div class="text-sm text-muted-foreground">Total Eggs</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-success">{{ $booking->hatched_count ?? 0 }}</div>
                    <div class="text-sm text-muted-foreground">Hatched</div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-8">
                    <!-- Customer Information -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Customer Information</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-medium text-card-foreground">Full Name *</label>
                                <input type="text" name="name" id="name" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('name', $booking->name) }}" required>
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-card-foreground">Email Address *</label>
                                <input type="email" name="email" id="email" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('email', $booking->email) }}" required>
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-medium text-card-foreground">Phone Number *</label>
                                <input type="text" name="phone" id="phone" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('phone', $booking->phone) }}" required>
                            </div>
                            <div class="space-y-2">
                                <label for="address" class="text-sm font-medium text-card-foreground">Address</label>
                                <input type="text" name="address" id="address" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('address', $booking->address) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Service Information</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="service_type" class="text-sm font-medium text-card-foreground">Service Type *</label>
                                <select name="service_type" id="service_type" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" required>
                                    @foreach($serviceTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('service_type', $booking->service_type) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="egg_quantity" class="text-sm font-medium text-card-foreground">Number of Eggs *</label>
                                <input type="number" name="egg_quantity" id="egg_quantity" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('egg_quantity', $booking->egg_quantity) }}" min="1" required>
                            </div>
                            <div class="space-y-2">
                                <label for="egg_source" class="text-sm font-medium text-card-foreground">Egg Source</label>
                                <select name="egg_source" id="egg_source" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                                    <option value="">Select Egg Source</option>
                                    <option value="own_farm" {{ old('egg_source', $booking->egg_source) == 'own_farm' ? 'selected' : '' }}>Customer's Own Farm</option>
                                    <option value="jm_casabar" {{ old('egg_source', $booking->egg_source) == 'jm_casabar' ? 'selected' : '' }}>JM Casabar Pekin Store</option>
                                    <option value="other_supplier" {{ old('egg_source', $booking->egg_source) == 'other_supplier' ? 'selected' : '' }}>Other Supplier</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="start_date" class="text-sm font-medium text-card-foreground">Start Date *</label>
                                <input type="date" name="start_date" id="start_date" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('start_date', $booking->start_date ? $booking->start_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="space-y-2">
                                <label for="special_instructions" class="text-sm font-medium text-card-foreground">Special Instructions</label>
                                <textarea name="special_instructions" id="special_instructions" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3">{{ old('special_instructions', $booking->special_instructions) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Status & Progress -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Status & Progress</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="status" class="text-sm font-medium text-card-foreground">Status *</label>
                                <select name="status" id="status" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" required>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $booking->status) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="status_notes" class="text-sm font-medium text-card-foreground">Status Notes</label>
                                <textarea name="status_notes" id="status_notes" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3">{{ old('status_notes', $booking->status_notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Payment Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-card-foreground">Deposit Status</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="deposit_paid" id="deposit_paid" class="rounded border-border text-accent focus:ring-accent" {{ old('deposit_paid', $booking->deposit_paid) ? 'checked' : '' }}>
                                        <label for="deposit_paid" class="text-sm text-card-foreground">Deposit Paid</label>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-card-foreground">Balance Status</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="balance_paid" id="balance_paid" class="rounded border-border text-accent focus:ring-accent" {{ old('balance_paid', $booking->balance_paid) ? 'checked' : '' }}>
                                        <label for="balance_paid" class="text-sm text-card-foreground">Balance Paid</label>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="payment_method" class="text-sm font-medium text-card-foreground">Payment Method</label>
                                <input type="text" name="payment_method" id="payment_method" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('payment_method', $booking->payment_method) }}">
                            </div>
                            <div class="space-y-2">
                                <label for="payment_reference" class="text-sm font-medium text-card-foreground">Payment Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('payment_reference', $booking->payment_reference) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Candling Results -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Candling Results</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="first_candling_fertile_count" class="text-sm font-medium text-card-foreground">First Candling - Fertile Count</label>
                                <input type="number" name="first_candling_fertile_count" id="first_candling_fertile_count" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('first_candling_fertile_count', $booking->first_candling_fertile_count) }}" min="0">
                            </div>
                            <div class="space-y-2">
                                <label for="second_candling_fertile_count" class="text-sm font-medium text-card-foreground">Second Candling - Fertile Count</label>
                                <input type="number" name="second_candling_fertile_count" id="second_candling_fertile_count" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('second_candling_fertile_count', $booking->second_candling_fertile_count) }}" min="0">
                            </div>
                            <div class="space-y-2">
                                <label for="candling_notes" class="text-sm font-medium text-card-foreground">Candling Notes</label>
                                <textarea name="candling_notes" id="candling_notes" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3">{{ old('candling_notes', $booking->candling_notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Hatching Results -->
                    <div class="bg-card rounded-xl border border-border p-6">
                        <h3 class="text-lg font-semibold text-card-foreground mb-6">Hatching Results</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="hatched_count" class="text-sm font-medium text-card-foreground">Hatched Count</label>
                                <input type="number" name="hatched_count" id="hatched_count" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('hatched_count', $booking->hatched_count) }}" min="0">
                            </div>
                            <div class="space-y-2">
                                <label for="hatching_notes" class="text-sm font-medium text-card-foreground">Hatching Notes</label>
                                <textarea name="hatching_notes" id="hatching_notes" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3">{{ old('hatching_notes', $booking->hatching_notes) }}</textarea>
                            </div>
                            @if($booking->hatch_rate)
                                <div class="p-3 bg-success/10 rounded-lg">
                                    <p class="text-sm text-success font-medium">
                                        Current Hatch Rate: {{ number_format($booking->hatch_rate, 1) }}%
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.incubation.index') }}" class="px-6 py-2 text-muted-foreground hover:text-card-foreground transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium">
                    Update Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
