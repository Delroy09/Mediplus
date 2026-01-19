@extends('layouts.master')

@section('title', 'Contact & Request Account')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill mb-3">Get Started</span>
            <h1 class="display-5 fw-bold mb-3">Request Your Account</h1>
            <p class="lead text-muted">Fill out the form below and our IT team will review your application</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-header bg-gradient text-white py-3" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
                    <h4 class="mb-0 fw-bold">📋 Application Form</h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required>

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="e.g. mediplus@gmail.com" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">We will send your login credentials here.</div>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="number" class="form-control @error('mobile_number') is-invalid @enderror"
                                id="mobile" name="mobile_number" value="{{ old('mobile_number') }}"
                                pattern="[0-9]{10}" maxlength="10" inputmode="numeric"
                                title="Please enter a 10-digit mobile number" placeholder="e.g. 7249522138" required>
                            @error('mobile_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Reason for joining (Optional)</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="e.g. I had severe obesity & constipation...">{{ old('message') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-light py-3">
                    <h4 class="mb-0 fw-bold text-center">❓ Frequently Asked Questions</h4>
                </div>
                <div class="card-body p-4">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <strong>How long does the approval process take?</strong>
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    The IT department typically reviews applications within 24-48 hours. You will receive an email with your login credentials once approved. In urgent cases, please contact our support team directly.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <strong>What information do I need to provide?</strong>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You'll need to provide your full name, a valid email address, and a 10-digit mobile number. Optionally, you can mention your reason for joining to help us process your request faster.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <strong>Can I request an account for someone else?</strong>
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can request an account on behalf of a patient or family member. Please ensure you provide their accurate contact information and mention in the message that you're applying on their behalf.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <strong>Is my personal information secure?</strong>
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely. All data is encrypted and stored securely. Only authorized IT administrators can access your information, and we comply with all medical data protection regulations. Your privacy is our top priority.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection