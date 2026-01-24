@extends('layouts.dashboard-layout')

@section('page-title', 'Admin Dashboard')

@section('sidebar-menu')
<nav class="nav flex-column">
    <a class="nav-link active" href="{{ route('admin.dashboard') }}">Account Requests</a>
    <a class="nav-link" href="#">Manage Users</a>
    <a class="nav-link" href="#">System Settings</a>
</nav>
@endsection

@section('content')
<style>
    .section-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
    }

    .section-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .section-title {
        font-weight: 600;
        color: #2b5797;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e8f0fe;
    }

    .table-container {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e0e7ef;
    }

    .scrollable-table {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 8px;
    }

    .table thead th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-sm {
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="content-box">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Pending Requests Section -->
    <div class="section-card">
        <h4 class="section-title">Pending Account Requests</h4>

        @if($pendingRequests->count() > 0)
        <div class="table-container">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Message</th>
                        <th>Requested On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRequests as $request)
                    <tr>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->mobile_number }}</td>
                        <td>{{ Str::limit($request->message, 50) }}</td>
                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                Approve
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                Reject
                            </button>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 12px; border: none;">
                                        <form action="{{ route('admin.approve', $request->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header" style="border-bottom: 1px solid #e8f0fe;">
                                                <h5 class="modal-title">Approve & Assign Doctor</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $request->name }}</p>
                                                <p><strong>Email:</strong> {{ $request->email }}</p>
                                                <p><strong>Mobile:</strong> {{ $request->mobile_number }}</p>
                                                <div class="mb-3">
                                                    <label class="form-label">Assign to Doctor *</label>
                                                    <select name="doctor_id" class="form-select" style="border-radius: 8px;" required>
                                                        <option value="">-- Select Doctor --</option>
                                                        @foreach($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}">
                                                            {{ $doctor->user->name }} - {{ $doctor->specialization }} ({{ $doctor->patients_count }} patients)
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #e8f0fe;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                                <button type="submit" class="btn btn-success" style="border-radius: 8px;">Approve & Assign</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 12px; border: none;">
                                        <form action="{{ route('admin.reject', $request->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header" style="border-bottom: 1px solid #e8f0fe;">
                                                <h5 class="modal-title">Reject Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $request->name }}</p>
                                                <p><strong>Email:</strong> {{ $request->email }}</p>
                                                <div class="mb-3">
                                                    <label class="form-label">Rejection Reason</label>
                                                    <textarea name="rejection_reason" class="form-control" rows="3" style="border-radius: 8px;" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #e8f0fe;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                                <button type="submit" class="btn btn-danger" style="border-radius: 8px;">Confirm Rejection</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted mb-0">No pending requests.</p>
        @endif
    </div>

    <!-- All Doctors Section -->
    <div class="section-card">
        <h4 class="section-title">All Doctors</h4>

        @if($doctors->count() > 0)
        <div class="table-container scrollable-table">
            <table class="table table-sm table-striped mb-0">
                <thead style="position: sticky; top: 0; background-color: #f8fafc; z-index: 10;">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Assigned Patients</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->user->name }}</td>
                        <td>{{ $doctor->user->email }}</td>
                        <td>{{ $doctor->specialization }}</td>
                        <td>{{ $doctor->department }}</td>
                        <td><span class="badge bg-primary">{{ $doctor->patients_count }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted mb-0">No doctors found.</p>
        @endif
    </div>

    <!-- All Patients Section -->
    <div class="section-card">
        <h4 class="section-title">All Patients</h4>

        @if($patients->count() > 0)
        <div class="table-container scrollable-table">
            <table class="table table-sm table-striped mb-0">
                <thead style="position: sticky; top: 0; background-color: #f8fafc; z-index: 10;">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->user->name }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>{{ $patient->mobile_number }}</td>
                        <td>{{ $patient->blood_group }}</td>
                        <td>
                            <span class="badge
                                @if($patient->status === 'Admitted') status-admitted
                                @elseif($patient->status === 'Surgery') status-surgery
                                @elseif($patient->status === 'Discharged') status-discharged
                                @else status-admitted
                                @endif">
                                {{ $patient->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted mb-0">No patients found.</p>
        @endif
    </div>

    <!-- Patient-Doctor Assignments Section -->
    <div class="section-card">
        <h4 class="section-title">Patient-Doctor Assignments</h4>

        @if($patients->count() > 0)
        <div class="table-container scrollable-table">
            <table class="table table-sm table-striped mb-0">
                <thead style="position: sticky; top: 0; background-color: #f8fafc; z-index: 10;">
                    <tr>
                        <th>Patient</th>
                        <th>Assigned Doctor(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->user->name }}</td>
                        <td>
                            @if($patient->doctors->count() > 0)
                            @foreach($patient->doctors as $doctor)
                            <span class="badge bg-info" style="margin: 2px;">{{ $doctor->user->name }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">No doctor assigned</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.reassign-doctor', $patient->id) }}" method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                                @csrf
                                <select name="doctor_id" class="form-select form-select-sm" style="min-width: 220px; border-radius: 8px;" required>
                                    <option value="">-- Select Doctor --</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ $patient->doctors->contains('id', $doctor->id) ? 'selected' : '' }}>
                                        {{ $doctor->user->name }} - {{ $doctor->specialization }} ({{ $doctor->patients_count }} patients)
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                                    Assign
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted mb-0">No patients found.</p>
        @endif
    </div>
</div>
@endsection