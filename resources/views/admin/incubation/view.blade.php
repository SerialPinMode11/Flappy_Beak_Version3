@extends('layouts.static')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Booking Details: {{ $booking->booking_reference }}
        </h1>
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Booking
            </a>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Booking Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
                    <span class="badge badge-{{ $statusColors[$booking->status] ?? 'secondary' }} p-2">
                        {{ $booking->status_name }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Customer Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Name:</th>
                                    <td>{{ $booking->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $booking->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $booking->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $booking->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Service Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Service:</th>
                                    <td>{{ $booking->service_type_name }}</td>
                                </tr>
                                <tr>
                                    <th>Eggs:</th>
                                    <td>{{ $booking->egg_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Source:</th>
                                    <td>{{ $booking->egg_source_name }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date:</th>
                                    <td>{{ $booking->start_date ? $booking->start_date->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th>Expected End:</th>
                                    <td>{{ $booking->expected_completion_date ? $booking->expected_completion_date->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="font-weight-bold">Special Instructions</h5>
                            <p>{{ $booking->special_instructions ?: 'No special instructions provided.' }}</p>
                        </div>
                    </div>

                    <div class  }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Payment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Total Price:</th>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Deposit:</th>
                                    <td>₱{{ number_format($booking->deposit_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Deposit Paid:</th>
                                    <td>
                                        @if($booking->deposit_paid)
                                            <span class="badge badge-success">Paid on {{ $booking->deposit_paid_at->format('M d, Y') }}</span>
                                        @else
                                            <span class="badge badge-danger">Not Paid</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Balance:</th>
                                    <td>₱{{ number_format($booking->total_price - $booking->deposit_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Balance Paid:</th>
                                    <td>
                                        @if($booking->balance_paid)
                                            <span class="badge badge-success">Paid on {{ $booking->balance_paid_at->format('M d, Y') }}</span>
                                        @else
                                            <span class="badge badge-danger">Not Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Booking Timeline</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Created:</th>
                                    <td>{{ $booking->created_at->format('M d, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Confirmed:</th>
                                    <td>
                                        @if($booking->confirmed_at)
                                            {{ $booking->confirmed_at->format('M d, Y g:i A') }}
                                        @else
                                            <span class="text-muted">Not confirmed yet</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Update:</th>
                                    <td>{{ $booking->updated_at->format('M d, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Notes:</th>
                                    <td>{{ $booking->status_notes ?: 'No status notes' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Progress -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Incubation Progress</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Progress <span class="float-right">{{ $booking->progress_percent }}%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-{{ $progressColors[$booking->status] ?? 'info' }}" role="progressbar" style="width: {{ $booking->progress_percent }}%" aria-valuenow="{{ $booking->progress_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <h5 class="font-weight-bold">Current Phase</h5>
                    <p>{{ $booking->current_phase }}</p>

                    <h5 class="font-weight-bold mt-4">Candling Results</h5>
                    <table class="table table-sm">
                        <tr>
                            <th>First Candling:</th>
                            <td>
                                @if($booking->first_candling_fertile_count !== null)
                                    {{ $booking->first_candling_fertile_count }} fertile eggs
                                    @if($booking->egg_quantity > 0)
                                        ({{ round(($booking->first_candling_fertile_count / $booking->egg_quantity) * 100) }}%)
                                    @endif
                                @else
                                    <span class="text-muted">Not recorded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Second Candling:</th>
                            <td>
                                @if($booking->second_candling_fertile_count !== null)
                                    {{ $booking->second_candling_fertile_count }} fertile eggs
                                    @if($booking->egg_quantity > 0)
                                        ({{ round(($booking->second_candling_fertile_count / $booking->egg_quantity) * 100) }}%)
                                    @endif
                                @else
                                    <span class="text-muted">Not recorded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Candling Notes:</th>
                            <td>{{ $booking->candling_notes ?: 'No notes' }}</td>
                        </tr>
                    </table>

                    <h5 class="font-weight-bold mt-4">Hatching Results</h5>
                    <table class="table table-sm">
                        <tr>
                            <th>Hatched:</th>
                            <td>
                                @if($booking->hatched_count !== null)
                                    {{ $booking->hatched_count }} ducklings
                                @else
                                    <span class="text-muted">Not recorded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Hatch Rate:</th>
                            <td>
                                @if($booking->hatch_rate !== null)
                                    {{ round($booking->hatch_rate) }}%
                                @else
                                    <span class="text-muted">Not recorded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Hatching Notes:</th>
                            <td>{{ $booking->hatching_notes ?: 'No notes' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-block mb-2" data-toggle="modal" data-target="#statusUpdateModal">
                        <i class="fas fa-sync-alt"></i> Update Status
                    </button>
                    
                    <button type="button" class="btn btn-info btn-block mb-2" data-toggle="modal" data-target="#candlingModal">
                        <i class="fas fa-eye"></i> Record Candling Results
                    </button>
                    
                    <button type="button" class="btn btn-success btn-block mb-2" data-toggle="modal" data-target="#hatchingModal">
                        <i class="fas fa-baby"></i> Record Hatching Results
                    </button>
                    
                    <button type="button" class="btn btn-warning btn-block mb-2" data-toggle="modal" data-target="#paymentModal">
                        <i class="fas fa-money-bill-wave"></i> Record Payment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusUpdateModalLabel">Update Booking Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $booking->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_notes">Status Notes</label>
                            <textarea name="status_notes" id="status_notes" class="form-control" rows="3">{{ $booking->status_notes }}</textarea>
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

    <!-- Candling Modal -->
    <div class="modal fade" id="candlingModal" tabindex="-1" role="dialog" aria-labelledby="candlingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.bookings.record-candling', $booking->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="candlingModalLabel">Record Candling Results</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="is_first_candling">Candling Phase</label>
                            <select name="is_first_candling" id="is_first_candling" class="form-control" required>
                                <option value="1">First Candling (Day 7)</option>
                                <option value="0">Second Candling (Day 14)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fertile_count">Number of Fertile Eggs</label>
                            <input type="number" name="fertile_count" id="fertile_count" class="form-control" min="0" max="{{ $booking->egg_quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="candling_notes">Notes</label>
                            <textarea name="candling_notes" id="candling_notes" class="form-control" rows="3">{{ $booking->candling_notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Results</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hatching Modal -->
    <div class="modal fade" id="hatchingModal" tabindex="-1" role="dialog" aria-labelledby="hatchingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.bookings.record-hatching', $booking->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="hatchingModalLabel">Record Hatching Results</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="hatched_count">Number of Hatched Ducklings</label>
                            <input type="number" name="hatched_count" id="hatched_count" class="form-control" min="0" max="{{ $booking->egg_quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="hatching_notes">Notes</label>
                            <textarea name="hatching_notes" id="hatching_notes" class="form-control" rows="3">{{ $booking->hatching_notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Results</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
