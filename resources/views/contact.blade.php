@extends('layouts.master')

@section('title', 'Contact & Request Account')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">Request Your Account</h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem;">Fill out the form below and our IT team will review your application</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-5">
                <div class="card-header bg-white py-4" style="border-bottom: 1px solid var(--border-color);">
                    <h4 class="mb-0 fw-bold">Application Form</h4>
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

                    <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">Full Name <span style="color: #DC2626;">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required aria-required="true" aria-describedby="nameHelp">

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span style="color: #DC2626;">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="e.g. mediplus@gmail.com" required aria-required="true" aria-describedby="emailHelp">
                            @error('email')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="emailHelp">We will send your login credentials here.</div>
                        </div>

                        <div class="mb-4">
                            <label for="mobile" class="form-label">Mobile Number <span style="color: #DC2626;">*</span></label>
                            <input type="tel" class="form-control @error('mobile_number') is-invalid @enderror"
                                id="mobile" name="mobile_number" value="{{ old('mobile_number') }}"
                                pattern="[0-9]{10}" maxlength="10" inputmode="numeric"
                                title="Please enter a 10-digit mobile number" placeholder="e.g. 7249522138" required aria-required="true" aria-describedby="mobileHelp">
                            @error('mobile_number')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="mobileHelp">10-digit mobile number without spaces or dashes.</div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Reason for joining <span style="color: var(--text-secondary); font-weight: 400;">(Optional)</span></label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Briefly describe why you need an account..." aria-describedby="messageHelp">{{ old('message') }}</textarea>
                            <div class="form-text" id="messageHelp">This helps us process your request faster.</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="card mt-4">
                <div class="card-header bg-white py-4" style="border-bottom: 1px solid var(--border-color);">
                    <h4 class="mb-0 fw-bold">Frequently Asked Questions</h4>
                </div>
                <div class="card-body p-4">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <strong>How long does the approval process take?</strong>
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    The IT department typically reviews applications within 24-48 hours. You will receive an email with your login credentials once approved. In urgent cases, please contact our support team directly.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <strong>What information do I need to provide?</strong>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You'll need to provide your full name, a valid email address, and a 10-digit mobile number. Optionally, you can mention your reason for joining to help us process your request faster.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <strong>Can I request an account for someone else?</strong>
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can request an account on behalf of a patient or family member. Please ensure you provide their accurate contact information and mention in the message that you're applying on their behalf.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
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