@extends('NewUI.layouts.master_v2')

@section('title', 'Request Account')

@section('content')

<!-- Hero Banner -->
<section style="background: var(--bg-white); padding: 3rem 0 2rem;">
    <div class="container">
        <div class="text-center">
            <span class="tag-label">Get Started</span>
            <h1 class="font-serif mt-2" style="font-size: clamp(2rem, 4vw, 2.75rem);">Request Your Account</h1>
            <p style="color: var(--text-secondary); max-width: 500px; margin: 1rem auto 0;">
                Fill out the form below and our team will review your application within 24-48 hours
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section style="background: var(--bg-cream); padding: 3rem 0 5rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card-v2">
                    <div class="card-header">
                        <h4 class="mb-0 fw-semibold" style="font-size: 1.1rem;">
                            <span style="color: var(--primary);">📋</span> Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: #ECFDF5; color: #065F46;">
                            <span style="margin-right: 0.5rem;">✓</span> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger" style="border-radius: 12px; border: none; background: #FEF2F2; color: #991B1B;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                <li><span style="margin-right: 0.5rem;">⚠</span> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('contact.v2.submit') }}" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label-v2">Full Name <span style="color: #DC2626;">*</span></label>
                                <input type="text"
                                    class="form-control form-control-v2 @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label-v2">Email Address <span style="color: #DC2626;">*</span></label>
                                <input type="email"
                                    class="form-control form-control-v2 @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="e.g. yourname@email.com"
                                    required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                                    We'll send your login credentials to this email
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="mobile" class="form-label-v2">Mobile Number <span style="color: #DC2626;">*</span></label>
                                <input type="tel"
                                    class="form-control form-control-v2 @error('mobile_number') is-invalid @enderror"
                                    id="mobile"
                                    name="mobile_number"
                                    value="{{ old('mobile_number') }}"
                                    pattern="[0-9]{10}"
                                    maxlength="10"
                                    inputmode="numeric"
                                    placeholder="e.g. 7249522138"
                                    required>
                                @error('mobile_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                                    10-digit mobile number without spaces or dashes
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label-v2">
                                    Reason for joining
                                    <span style="color: var(--text-muted); font-weight: 400;">(Optional)</span>
                                </label>
                                <textarea
                                    class="form-control form-control-v2"
                                    id="message"
                                    name="message"
                                    rows="4"
                                    placeholder="Briefly describe why you need an account...">{{ old('message') }}</textarea>
                                <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                                    This helps us process your request faster
                                </small>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn-cta" style="width: 100%; justify-content: center; padding: 1rem;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                        <path d="M22 2L11 13"></path>
                                        <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                                    </svg>
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ Sidebar -->
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="card-v2">
                    <div class="card-header">
                        <h4 class="mb-0 fw-semibold" style="font-size: 1.1rem;">
                            <span style="color: var(--primary);">❓</span> Frequently Asked Questions
                        </h4>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div class="accordion accordion-flush" id="faqAccordion">
                            <div class="accordion-item" style="border: none; border-bottom: 1px solid var(--border-color);">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="font-size: 0.95rem; padding: 1.25rem 1.5rem;">
                                        How long does approval take?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.9rem;">
                                        Our IT team typically reviews applications within 24-48 hours. You'll receive an email with your login credentials once approved.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item" style="border: none; border-bottom: 1px solid var(--border-color);">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="font-size: 0.95rem; padding: 1.25rem 1.5rem;">
                                        What information do I need?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.9rem;">
                                        Just your full name, email address, and mobile number. Optionally, you can mention why you're joining.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item" style="border: none; border-bottom: 1px solid var(--border-color);">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="font-size: 0.95rem; padding: 1.25rem 1.5rem;">
                                        Can I apply for someone else?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.9rem;">
                                        Yes! You can apply on behalf of a patient or family member. Just provide their accurate contact information.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item" style="border: none;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" style="font-size: 0.95rem; padding: 1.25rem 1.5rem;">
                                        Is my data secure?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.9rem;">
                                        Absolutely. All data is encrypted and stored securely. We comply with all medical data protection regulations.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card-v2 mt-4">
                    <div class="card-body" style="padding: 1.5rem;">
                        <h5 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Need Help?</h5>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--text-secondary); font-size: 0.9rem;">
                                <span style="width: 32px; height: 32px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">📧</span>
                                dav000@chowgules.ac.in
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--text-secondary); font-size: 0.9rem;">
                                <span style="width: 32px; height: 32px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">📞</span>
                                +91 724 952 2138
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
<style>
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-light);
        color: var(--primary-dark);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: var(--border-color);
    }

    .accordion-button::after {
        width: 1rem;
        height: 1rem;
        background-size: 1rem;
    }

    /* Fix accordion collapse */
    .accordion-collapse {
        transition: height 0.35s ease;
    }

    .accordion-item {
        background-color: transparent;
    }

    .accordion-button {
        background-color: var(--bg-white);
    }

    .form-control-v2.is-invalid {
        border-color: #DC2626;
    }

    .form-control-v2.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    // Manual accordion initialization as fallback
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Bootstrap is loaded
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap JS not loaded!');
            return;
        }

        // Initialize all accordions
        var accordionButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
        accordionButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('data-bs-target');
                var target = document.querySelector(targetId);

                if (target) {
                    var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target);
                    bsCollapse.toggle();
                }
            });
        });
    });
</script>
@endsection