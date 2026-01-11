@extends('layouts.master')

@section('title', 'Patient Dashboard')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar / Welcome Section -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 border-top border-primary border-4">
                <div class="card-body text-center">
                    <div class="display-1 text-primary mb-3">
                        <i class="bi bi-person-circle"></i> <!-- Bootstrap Icons assumed, or generic text -->
                        👤
                    </div>
                    <h3 class="card-title">Welcome, {{ $user->name ?? 'Patient Name' }}</h3>
                    <p class="text-muted mb-4">{{ $user->email ?? 'patient@example.com' }}</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-danger">Logout</button>
                    </div>
                </div>
            </div>

            <!-- Assigned Doctor Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">👨‍⚕️ Assigned Doctor</h5>
                </div>
                <div class="card-body">
                    <!-- Dynamic Data Placeholder -->
                    <h6 class="fw-bold">Dr. {{ $doctor->name ?? 'Unassigned' }}</h6>
                    <p class="small text-muted mb-0">Specialization: {{ $doctor->specialization ?? 'N/A' }}</p>
                    <p class="small text-muted">Department: {{ $doctor->department ?? 'General' }}</p>
                    
                    @if(isset($doctor))
                        <a href="#" class="btn btn-sm btn-primary w-100">View Schedule</a>
                    @else
                        <div class="alert alert-warning py-2 small mb-0">No doctor assigned yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-8">
            
            <!-- Personal Information (Edit Mobile Only) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">My Personal Details</h5>
                    <span class="badge bg-success">Admitted</span> <!-- Dynamic Status -->
                </div>
                <div class="card-body">
                    <form action="#" method="POST"> <!-- Route needed -->
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Full Name</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->name ?? 'John Doe' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Date of Birth</label>
                                <input type="text" class="form-control bg-light" value="{{ $patient->dob ?? '1990-01-01' }}" readonly>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-muted">Blood Group</label>
                                <input type="text" class="form-control bg-light" value="{{ $patient->blood_group ?? 'O+' }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="form-label fw-bold text-dark">Mobile Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control border-primary" id="mobile" name="mobile_number" value="{{ $patient->mobile_number ?? '555-0199' }}">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                                <div class="form-text">This is the only field you can update directly.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-muted">Permanent Address</label>
                                <textarea class="form-control bg-light" rows="2" readonly>{{ $patient->address ?? '123 Main St, Springfield' }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Medical History (Read Only) -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Medical History & Notes</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> These records are managed by your assigned doctor.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Diagnosis / History</label>
                        <div class="p-3 bg-light border rounded">
                            {{ $patient->medical_history ?? 'No history recorded yet.' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Visit</label>
                        <input type="text" class="form-control-plaintext" value="{{ $patient->last_visited_date ?? 'N/A' }}" readonly>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
