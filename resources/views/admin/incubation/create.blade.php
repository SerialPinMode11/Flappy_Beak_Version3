@extends('layouts.static')

@section('title', 'Create New Incubation Booking')

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
                    <h1 class="text-xl font-bold text-primary-foreground" style="color: black">Create New Incubation Booking</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <!-- Create Form -->
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Customer Information -->
            <div class="bg-card rounded-xl border border-border p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-6">Customer Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-card-foreground">Full Name *</label>
                        <input type="text" name="name" id="name" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('name') }}" required>
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-card-foreground">Email Address *</label>
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('email') }}" required>
                    </div>
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-medium text-card-foreground">Phone Number *</label>
                        <input type="text" name="phone" id="phone" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('phone') }}" required>
                    </div>
                    <div class="space-y-2">
                        <label for="address" class="text-sm font-medium text-card-foreground">Address</label>
                        <input type="text" name="address" id="address" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('address') }}">
                    </div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="bg-card rounded-xl border border-border p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-6">Service Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="service_type" class="text-sm font-medium text-card-foreground">Service Type *</label>
                        <select name="service_type" id="service_type" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" required>
                            <option value="">Select Service Type</option>
                            <option value="jm_casabar" {{ old('service_type') == 'jm_casabar' ? 'selected' : '' }}>JM Casabar Formula Incubation</option>
                            <option value="custom" {{ old('service_type') == 'custom' ? 'selected' : '' }}>Custom Formula Incubation</option>
                            <option value="experimental" {{ old('service_type') == 'experimental' ? 'selected' : '' }}>Experimental Formula Incubation</option>
                            <option value="world_based" {{ old('service_type') == 'world_based' ? 'selected' : '' }}>World-Based Formula Incubation</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="egg_quantity" class="text-sm font-medium text-card-foreground">Number of Eggs *</label>
                        <input type="number" name="egg_quantity" id="egg_quantity" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('egg_quantity') }}" min="1" required>
                    </div>
                    <div class="space-y-2">
                        <label for="egg_source" class="text-sm font-medium text-card-foreground">Egg Source</label>
                        <select name="egg_source" id="egg_source" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground">
                            <option value="">Select Egg Source</option>
                            <option value="own_farm" {{ old('egg_source') == 'own_farm' ? 'selected' : '' }}>Customer's Own Farm</option>
                            <option value="jm_casabar" {{ old('egg_source') == 'jm_casabar' ? 'selected' : '' }}>JM Casabar Pekin Store</option>
                            <option value="other_supplier" {{ old('egg_source') == 'other_supplier' ? 'selected' : '' }}>Other Supplier</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="start_date" class="text-sm font-medium text-card-foreground">Start Date *</label>
                        <input type="date" name="start_date" id="start_date" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('start_date') }}" required>
                    </div>
                </div>
                <div class="mt-6 space-y-2">
                    <label for="special_instructions" class="text-sm font-medium text-card-foreground">Special Instructions</label>
                    <textarea name="special_instructions" id="special_instructions" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" rows="3" placeholder="Any special requirements or instructions...">{{ old('special_instructions') }}</textarea>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="bg-card rounded-xl border border-border p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-6">Pricing Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="total_price" class="text-sm font-medium text-card-foreground">Total Price</label>
                        <input type="number" name="total_price" id="total_price" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('total_price') }}" step="0.01" min="0">
                        <p class="text-xs text-muted-foreground">Leave empty to auto-calculate based on service type</p>
                    </div>
                    <div class="space-y-2">
                        <label for="deposit_amount" class="text-sm font-medium text-card-foreground">Deposit Amount</label>
                        <input type="number" name="deposit_amount" id="deposit_amount" class="w-full px-3 py-2 bg-input border border-border rounded-lg focus:ring-2 focus:ring-ring focus:border-transparent text-foreground" value="{{ old('deposit_amount') }}" step="0.01" min="0">
                        <p class="text-xs text-muted-foreground">Leave empty to auto-calculate (50% of total)</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.incubation.index') }}" class="px-6 py-2 text-muted-foreground hover:text-card-foreground transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium">
                    Create Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
