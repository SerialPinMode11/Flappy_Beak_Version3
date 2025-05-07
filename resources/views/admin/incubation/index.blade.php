@extends('layouts.static')

@section('title', 'Manage Incubation Bookings')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Incubation Bookings</h1>
        <a href="{{ route('admin.bookings.export') }}" class="btn btn-success">
            <i class="fas fa-file-export"></i> Export to CSV
        </a>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Active Incubations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['active'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-temperature-high fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['completed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Bookings</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row">
                <div class="col-md-2 mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="service_type">Service Type</label>
                    <select name="service_type" id="service_type" class="form-control">
                        <option value="">All Types</option>
                        @foreach($serviceTypes as $value => $label)
                            <option value="{{ $value }}" {{ request('service_type') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="date_from">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="date_to">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Name, Email, Reference..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Bookings</h6>
            <span class="text-muted">Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} bookings</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Eggs</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_reference }}</td>
                                <td>
                                    <div>{{ $booking->name }}</div>
                                    <div class="small text-muted">{{ $booking->email }}</div>
                                    <div class="small text-muted">{{ $booking->phone }}</div>
                                </td>
                                <td>
                                    @php
                                        $serviceColors = [
                                            'jm_casabar' => 'primary',
                                            'custom' => 'info',
                                            'experimental' => 'warning',
                                            'world_based' => 'success',
                                        ];
                                        $color = $serviceColors[$booking->service_type] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $color }}">
                                        {{ $booking->service_type_name }}
                                    </span>
                                </td>
                                <td>{{ $booking->egg_quantity }}</td>
                                <td>{{ $booking->start_date ? $booking->start_date->format('M d, Y') : 'Not set' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'in_progress' => 'primary',
                                            'candling' => 'primary',
                                            'lockdown' => 'primary',
                                            'hatching' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                        $statusColor = $statusColors[$booking->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $statusColor }}">
                                        {{ $booking->status_name }}
                                    </span>
                                    
                                    @if($booking->deposit_paid)
                                        <span class="badge badge-success">Deposit Paid</span>
                                    @endif
                                    
                                    @if($booking->balance_paid)
                                        <span class="badge badge-success">Fully Paid</span>
                                    @endif
                                </td>
                                <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#statusModal{{ $booking->id }}">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Status Update Modal -->
                                    <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $booking->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="statusModalLabel{{ $booking->id }}">Update Status</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="status{{ $booking->id }}">Status</label>
                                                            <select name="status" id="status{{ $booking->id }}" class="form-control" required>
                                                                @foreach($statuses as $value => $label)
                                                                    <option value="{{ $value }}" {{ $booking->status == $value ? 'selected' : '' }}>
                                                                        {{ $label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status_notes{{ $booking->id }}">Notes</label>
                                                            <textarea name="status_notes" id="status_notes{{ $booking->id }}" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No bookings found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection