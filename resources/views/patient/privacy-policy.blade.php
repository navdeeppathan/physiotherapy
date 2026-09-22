@extends('layouts.app')

@section('title', 'Privacy Policy — PhysioPii Go | Personal & Medical Data Protection')
@section('meta_description', 'Official Privacy Policy for PhysioPii Go (com.patient.physiopii). Learn how we collect, store, secure, and manage your personal health information.')
@section('meta_keywords', 'PhysioPii privacy policy, healthcare data protection, patient privacy, PhysioPii Go, com.patient.physiopii, account deletion, medical data security')

@section('content')
<div class="main-wrapper">

    @include('layouts.header')

    {{-- ── HERO / BREADCRUMB ── --}}
    <section class="pp-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="pp-breadcrumb">
                            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                            <li class="separator"><i class="fas fa-chevron-right"></i></li>
                            <li class="active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                    <div class="pp-badge">
                        <i class="fas fa-shield-alt"></i> Official Legal &amp; Data Policy
                    </div>
                    <h1 class="pp-hero-title">Privacy Policy</h1>
                    <p class="pp-hero-desc">
                        PhysioPii Go &mdash; Transparent, Secure &amp; Responsible Health Data Privacy for Patients &amp; Healthcare Professionals.
                    </p>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="pp-meta-card">
                        <div class="pp-meta-row">
                            <span class="pp-meta-label"><i class="far fa-calendar-check"></i> Effective Date:</span>
                            <span class="pp-meta-val">September 22, 2026</span>
                        </div>
                        <div class="pp-meta-row">
                            <span class="pp-meta-label"><i class="fas fa-history"></i> Last Updated:</span>
                            <span class="pp-meta-val">September 22, 2026</span>
                        </div>
                        <div class="pp-meta-row">
                            <span class="pp-meta-label"><i class="fas fa-mobile-alt"></i> Application:</span>
                            <span class="pp-meta-val">PhysioPii Go</span>
                        </div>
                        <div class="pp-meta-row">
                            <span class="pp-meta-label"><i class="fas fa-cube"></i> Package:</span>
                            <span class="pp-meta-val code">com.patient.physiopii</span>
                        </div>
                        <div class="pp-meta-row">
                            <span class="pp-meta-label"><i class="fas fa-globe"></i> Website:</span>
                            <a href="https://physiopii.in" target="_blank" class="pp-meta-link">physiopii.in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── MAIN CONTENT SECTION ── --}}
    <section class="pp-body-section py-5">
        <div class="container">
            <div class="row">

                {{-- Left Sticky TOC --}}
                <div class="col-lg-4 col-xl-3 d-none d-lg-block">
                    <div class="pp-toc-wrapper sticky-top" style="top: 90px; z-index: 10;">
                        <div class="pp-toc-header">
                            <i class="fas fa-list-ul"></i> Table of Contents
                        </div>
                        <div class="pp-toc-list">
                            <a href="#sec-1" class="pp-toc-item">1. Introduction</a>
                            <a href="#sec-2" class="pp-toc-item">2. Our Role as a Platform</a>
                            <a href="#sec-3" class="pp-toc-item">3. Information We Collect</a>
                            <a href="#sec-4" class="pp-toc-item">4. Appointment Information</a>
                            <a href="#sec-5" class="pp-toc-item">5. Payment Information</a>
                            <a href="#sec-6" class="pp-toc-item">6. Location Information</a>
                            <a href="#sec-7" class="pp-toc-item">7. Photos, Videos &amp; Files</a>
                            <a href="#sec-8" class="pp-toc-item">8. How We Use Information</a>
                            <a href="#sec-9" class="pp-toc-item">9. Communication</a>
                            <a href="#sec-10" class="pp-toc-item">10. Sharing with Physiotherapists</a>
                            <a href="#sec-11" class="pp-toc-item">11. Information for Patients</a>
                            <a href="#sec-12" class="pp-toc-item">12. Third-Party Services</a>
                            <a href="#sec-13" class="pp-toc-item">13. Legal Disclosures</a>
                            <a href="#sec-14" class="pp-toc-item">14. Marketing Communications</a>
                            <a href="#sec-15" class="pp-toc-item">15. Cookies &amp; SDKs</a>
                            <a href="#sec-16" class="pp-toc-item">16. Rehab Progress Data</a>
                            <a href="#sec-17" class="pp-toc-item">17. Data Security</a>
                            <a href="#sec-18" class="pp-toc-item">18. Data Retention</a>
                            <a href="#sec-19" class="pp-toc-item highlight">19. Account &amp; Data Deletion</a>
                            <a href="#sec-20" class="pp-toc-item">20. Your Privacy Rights</a>
                            <a href="#sec-21" class="pp-toc-item">21. Children's Privacy</a>
                            <a href="#sec-22" class="pp-toc-item">22. Policy Changes</a>
                            <a href="#sec-23" class="pp-toc-item">23. Contact &amp; Grievance</a>
                        </div>
                    </div>
                </div>

                {{-- Policy Content --}}
                <div class="col-lg-8 col-xl-9">

                    {{-- Mobile Quick TOC Accordion --}}
                    <div class="d-lg-none mb-4">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-3">
                                <button class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#mobileTOC" aria-expanded="false">
                                    <span><i class="fas fa-list-ul mr-2"></i> Jump to Policy Section</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="collapse mt-3" id="mobileTOC">
                                    <div class="list-group list-group-flush small">
                                        <a href="#sec-1" class="list-group-item list-group-item-action py-2">1. Introduction</a>
                                        <a href="#sec-2" class="list-group-item list-group-item-action py-2">2. Our Role as a Platform</a>
                                        <a href="#sec-3" class="list-group-item list-group-item-action py-2">3. Information We Collect</a>
                                        <a href="#sec-4" class="list-group-item list-group-item-action py-2">4. Appointment Information</a>
                                        <a href="#sec-5" class="list-group-item list-group-item-action py-2">5. Payment Information</a>
                                        <a href="#sec-6" class="list-group-item list-group-item-action py-2">6. Location Information</a>
                                        <a href="#sec-7" class="list-group-item list-group-item-action py-2">7. Photos, Videos &amp; Files</a>
                                        <a href="#sec-8" class="list-group-item list-group-item-action py-2">8. How We Use Information</a>
                                        <a href="#sec-9" class="list-group-item list-group-item-action py-2">9. Communication</a>
                                        <a href="#sec-10" class="list-group-item list-group-item-action py-2">10. Sharing with Physiotherapists</a>
                                        <a href="#sec-11" class="list-group-item list-group-item-action py-2">11. Information for Patients</a>
                                        <a href="#sec-12" class="list-group-item list-group-item-action py-2">12. Third-Party Services</a>
                                        <a href="#sec-13" class="list-group-item list-group-item-action py-2">13. Legal Disclosures</a>
                                        <a href="#sec-14" class="list-group-item list-group-item-action py-2">14. Marketing Communications</a>
                                        <a href="#sec-15" class="list-group-item list-group-item-action py-2">15. Cookies &amp; SDKs</a>
                                        <a href="#sec-16" class="list-group-item list-group-item-action py-2">16. Rehab Progress Data</a>
                                        <a href="#sec-17" class="list-group-item list-group-item-action py-2">17. Data Security</a>
                                        <a href="#sec-18" class="list-group-item list-group-item-action py-2">18. Data Retention</a>
                                        <a href="#sec-19" class="list-group-item list-group-item-action py-2 font-weight-bold text-danger">19. Account &amp; Data Deletion</a>
                                        <a href="#sec-20" class="list-group-item list-group-item-action py-2">20. Your Privacy Rights</a>
                                        <a href="#sec-21" class="list-group-item list-group-item-action py-2">21. Children's Privacy</a>
                                        <a href="#sec-22" class="list-group-item list-group-item-action py-2">22. Policy Changes</a>
                                        <a href="#sec-23" class="list-group-item list-group-item-action py-2">23. Contact &amp; Grievance</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pp-article-card">

                        {{-- Section 1 --}}
                        <div class="pp-section" id="sec-1">
                            <div class="pp-sec-num">01</div>
                            <h2 class="pp-sec-title">Introduction</h2>
                            <div class="pp-sec-body">
                                <p>
                                    This Privacy Policy explains how <strong>PhysioPii (&ldquo;PhysioPii&rdquo;, &ldquo;we&rdquo;, &ldquo;us&rdquo;, or &ldquo;our&rdquo;)</strong> collects, uses, stores, shares, and protects personal information when you use the <strong>PhysioPii Go mobile application</strong>, website, and related services (collectively, the &ldquo;Platform&rdquo;).
                                </p>
                                <p>
                                    PhysioPii operates as a technology-enabled physiotherapy marketplace and aggregator connecting patients and users with physiotherapists and rehabilitation professionals for clinic appointments and home-visit physiotherapy services.
                                </p>
                                <div class="pp-callout">
                                    <div class="pp-callout-title"><i class="fas fa-users"></i> This Privacy Policy applies to:</div>
                                    <ul class="pp-list mb-0">
                                        <li>Patients and users</li>
                                        <li>Parents or guardians booking services for patients</li>
                                        <li>Physiotherapists and healthcare professionals using the Platform</li>
                                        <li>Visitors to the PhysioPii website</li>
                                        <li>Users communicating with PhysioPii</li>
                                    </ul>
                                </div>
                                <p class="mb-0">
                                    By using <strong>PhysioPii Go</strong>, you acknowledge that you have read and understood this Privacy Policy.
                                </p>
                            </div>
                        </div>

                        {{-- Section 2 --}}
                        <div class="pp-section" id="sec-2">
                            <div class="pp-sec-num">02</div>
                            <h2 class="pp-sec-title">Our Role as a Physiotherapy Platform</h2>
                            <div class="pp-sec-body">
                                <p>
                                    PhysioPii primarily provides technology and marketplace services that enable patients to discover and connect with physiotherapists and rehabilitation professionals.
                                </p>
                                <p>The Platform may facilitate:</p>
                                <div class="row pp-grid-features mb-3">
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Physiotherapist discovery</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Patient–physiotherapist connection</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Appointment booking &amp; scheduling</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Home-visit physiotherapy services</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Clinic sessions &amp; treatment tracking</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Payments, refunds &amp; receipts</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Patient information sharing for treatment</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Rehabilitation progress tracking &amp; digital reports</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Verified ratings and patient reviews</div>
                                    <div class="col-md-6 mb-2"><i class="fas fa-check-circle text-teal mr-2"></i> Dedicated customer support</div>
                                </div>
                                <p>
                                    The physiotherapist is responsible for the professional clinical assessment and treatment provided to the patient.
                                </p>
                                <p class="mb-0">
                                    To facilitate a booked service, PhysioPii may share relevant patient information with the selected physiotherapist. We aim to limit information sharing to what is reasonably necessary for the relevant service and applicable purposes.
                                </p>
                            </div>
                        </div>

                        {{-- Section 3 --}}
                        <div class="pp-section" id="sec-3">
                            <div class="pp-sec-num">03</div>
                            <h2 class="pp-sec-title">Information We Collect</h2>
                            <div class="pp-sec-body">
                                <p>Depending on how you use PhysioPii Go, we may collect different categories of information:</p>

                                <h4 class="pp-sub-title"><i class="fas fa-user-circle"></i> 3.1 Personal and Account Information</h4>
                                <ul class="pp-list">
                                    <li>Full name</li>
                                    <li>Mobile number</li>
                                    <li>Email address</li>
                                    <li>Date of birth or age where required</li>
                                    <li>Gender where voluntarily provided or necessary for a service</li>
                                    <li>Profile photograph where provided</li>
                                    <li>Login and account information</li>
                                </ul>

                                <h4 class="pp-sub-title"><i class="fas fa-map-marked-alt"></i> 3.2 Contact and Address Information</h4>
                                <ul class="pp-list">
                                    <li>Mobile number &amp; Email address</li>
                                    <li>Residential address &amp; Home-visit address</li>
                                    <li>City, Area/locality, Postal code</li>
                                    <li>Emergency contact information where provided or required</li>
                                </ul>
                                <p class="text-muted small">This information may be used to facilitate appointments, communication, and home physiotherapy services.</p>

                                <h4 class="pp-sub-title"><i class="fas fa-heartbeat"></i> 3.3 Health and Physiotherapy Information</h4>
                                <p>Because PhysioPii provides access to physiotherapy and rehabilitation services, users may voluntarily provide health-related information such as:</p>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="pp-list">
                                            <li>Diagnosis &amp; Symptoms</li>
                                            <li>Pain information &amp; Affected body area</li>
                                            <li>Medical history &amp; Previous surgery</li>
                                            <li>Injury history &amp; Functional limitations</li>
                                            <li>Mobility information &amp; Range of motion</li>
                                            <li>Strength &amp; Balance measurements</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="pp-list">
                                            <li>Physiotherapy assessment information</li>
                                            <li>Exercise plans &amp; Treatment notes</li>
                                            <li>Rehabilitation goals &amp; Progress measurements</li>
                                            <li>Outcome scores &amp; Exercise compliance</li>
                                            <li>Relevant medical reports, X-ray/MRI reports</li>
                                            <li>Images or videos relevant to rehabilitation</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="pp-alert-box alert-warning">
                                    <div class="d-flex">
                                        <i class="fas fa-shield-virus mr-3 fa-2x text-warning"></i>
                                        <div>
                                            <strong>Sensitive Health Data Protection:</strong>
                                            <p class="mb-0 mt-1">
                                                Some health information provided may be sensitive. We process such information strictly for appropriate purposes connected with your rehabilitation services and in accordance with applicable data protection laws.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4 --}}
                        <div class="pp-section" id="sec-4">
                            <div class="pp-sec-num">04</div>
                            <h2 class="pp-sec-title">Appointment Information</h2>
                            <div class="pp-sec-body">
                                <p>When you book a service, we may collect:</p>
                                <ul class="pp-list">
                                    <li>Selected physiotherapist</li>
                                    <li>Appointment date &amp; appointment time</li>
                                    <li>Service type &amp; package selected</li>
                                    <li>Session history &amp; session number tracking</li>
                                    <li>Booking status (confirmed, scheduled, completed, rescheduled, cancelled)</li>
                                    <li>Cancellation and rescheduling information</li>
                                    <li>Home-visit address</li>
                                    <li>Payment status</li>
                                </ul>
                                <p class="mb-0">This information allows us to manage your appointment, track package sessions, and provide the requested service.</p>
                            </div>
                        </div>

                        {{-- Section 5 --}}
                        <div class="pp-section" id="sec-5">
                            <div class="pp-sec-num">05</div>
                            <h2 class="pp-sec-title">Payment Information</h2>
                            <div class="pp-sec-body">
                                <p>When you make a payment, we may receive transaction information such as:</p>
                                <ul class="pp-list">
                                    <li>Transaction ID</li>
                                    <li>Payment status (e.g., success, pending, refunded)</li>
                                    <li>Amount paid</li>
                                    <li>Payment date and time</li>
                                    <li>Refund information</li>
                                    <li>Payment method (UPI, Netbanking, Cards)</li>
                                </ul>
                                <div class="pp-alert-box alert-info">
                                    <div class="d-flex">
                                        <i class="fas fa-credit-card mr-3 fa-2x text-info"></i>
                                        <div>
                                            <strong>Payment Gateway Security:</strong>
                                            <p class="mb-0 mt-1">
                                                Payments are processed securely through certified third-party payment gateways, including <strong>Razorpay</strong>. <strong>PhysioPii Go does NOT store full debit/credit card numbers, CVV numbers, UPI PINs, or banking passwords.</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 6 --}}
                        <div class="pp-section" id="sec-6">
                            <div class="pp-sec-num">06</div>
                            <h2 class="pp-sec-title">Location Information</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii Go may use precise or approximate device location information where required to:</p>
                                <ul class="pp-list">
                                    <li>Find verified physiotherapists serving your immediate area or neighborhood</li>
                                    <li>Facilitate timely home-visit physiotherapy services</li>
                                    <li>Calculate or determine service availability and travel duration</li>
                                    <li>Display relevant nearby service providers and clinic locations</li>
                                    <li>Provide appointment-related logistics and emergency assistance</li>
                                </ul>
                                <p class="mb-0">
                                    PhysioPii Go requests device location access only when necessary for a stated purpose and where permission is required. Users may disable device-level location permissions at any time in system settings, though location-based discovery may then become limited.
                                </p>
                            </div>
                        </div>

                        {{-- Section 7 --}}
                        <div class="pp-section" id="sec-7">
                            <div class="pp-sec-num">07</div>
                            <h2 class="pp-sec-title">Photos, Videos, Files and Documents</h2>
                            <div class="pp-sec-body">
                                <p>Users or treating physiotherapists may upload:</p>
                                <ul class="pp-list">
                                    <li>Medical reports &amp; doctor prescriptions</li>
                                    <li>X-rays, MRI scans, and diagnostic lab reports</li>
                                    <li>Physiotherapy assessment documents</li>
                                    <li>Progress photographs &amp; posture assessments</li>
                                    <li>Rehabilitation exercise and gait videos</li>
                                    <li>Other treatment-related records</li>
                                </ul>
                                <p class="mb-0 text-muted">
                                    Users should only upload information relevant to the intended medical/rehabilitation purpose and should not upload another person's information without appropriate authorization.
                                </p>
                            </div>
                        </div>

                        {{-- Section 8 --}}
                        <div class="pp-section" id="sec-8">
                            <div class="pp-sec-num">08</div>
                            <h2 class="pp-sec-title">How We Use Personal Information</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii uses personal information for the following specific purposes:</p>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="pp-feature-box h-100">
                                            <h5><i class="fas fa-cogs text-teal mr-2"></i> Platform Services</h5>
                                            <ul class="pp-list small mb-0">
                                                <li>Create and manage user accounts</li>
                                                <li>Connect patients with certified physiotherapists</li>
                                                <li>Display relevant physiotherapist profiles &amp; fees</li>
                                                <li>Facilitate bookings &amp; manage package sessions</li>
                                                <li>Process payments, cancellations &amp; refunds</li>
                                                <li>Facilitate home visits and clinic sessions</li>
                                                <li>Provide responsive customer support</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="pp-feature-box h-100">
                                            <h5><i class="fas fa-stethoscope text-teal mr-2"></i> Healthcare Functions</h5>
                                            <ul class="pp-list small mb-0">
                                                <li>Enable physiotherapists to review medical history</li>
                                                <li>Support clinical assessment documentation</li>
                                                <li>Maintain session histories &amp; exercise plans</li>
                                                <li>Track rehabilitation progress with range of motion</li>
                                                <li>Generate digital patient progress reports</li>
                                                <li>Facilitate communication for treatment care</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="pp-feature-box">
                                    <h5><i class="fas fa-shield-alt text-teal mr-2"></i> Platform Operations, Integrity &amp; Security</h5>
                                    <ul class="pp-list small mb-0">
                                        <li>Improve platform performance, responsiveness, and usability</li>
                                        <li>Maintain system security, audit logs, and encryption</li>
                                        <li>Detect and prevent fraud, unauthorized access, or misuse</li>
                                        <li>Troubleshoot technical issues and maintain appropriate statutory records</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Section 9 --}}
                        <div class="pp-section" id="sec-9">
                            <div class="pp-sec-num">09</div>
                            <h2 class="pp-sec-title">Communication</h2>
                            <div class="pp-sec-body">
                                <p>We may contact users via SMS, WhatsApp, Email, Phone, or in-app notifications regarding:</p>
                                <ul class="pp-list">
                                    <li>Appointment confirmations, reminders &amp; timings</li>
                                    <li>Rescheduling or cancellation updates</li>
                                    <li>Payment receipts and refund notifications</li>
                                    <li>Account activity and OTP verification</li>
                                    <li>Critical service, privacy, or security notices</li>
                                    <li>Customer support inquiries</li>
                                </ul>
                                <p class="mb-0 text-muted">
                                    Marketing communications will always be handled in accordance with applicable consent and communication guidelines.
                                </p>
                            </div>
                        </div>

                        {{-- Section 10 --}}
                        <div class="pp-section" id="sec-10">
                            <div class="pp-sec-num">10</div>
                            <h2 class="pp-sec-title">Sharing Information with Physiotherapists</h2>
                            <div class="pp-sec-body">
                                <p>When you book a physiotherapist through PhysioPii, we may share information necessary to fulfill the service:</p>
                                <ul class="pp-list">
                                    <li>Patient name, age, gender &amp; contact details</li>
                                    <li>Appointment schedule &amp; home-visit address</li>
                                    <li>Reported condition, pain description &amp; affected body area</li>
                                    <li>Relevant medical history and uploaded reports</li>
                                    <li>Treatment and rehabilitation progress notes</li>
                                </ul>
                                <p class="mb-0">
                                    This allows the physiotherapist to prepare for your session, conduct a clinical assessment, provide tailored therapy, and document progress. We aim to share only information reasonably necessary for your care.
                                </p>
                            </div>
                        </div>

                        {{-- Section 11 --}}
                        <div class="pp-section" id="sec-11">
                            <div class="pp-sec-num">11</div>
                            <h2 class="pp-sec-title">Information Available to Patients</h2>
                            <div class="pp-sec-body">
                                <p>Through PhysioPii Go, patients can view and access their health and service records at any time:</p>
                                <ul class="pp-list">
                                    <li>Appointment history, status &amp; remaining package sessions</li>
                                    <li>Treating physiotherapist credentials &amp; profile</li>
                                    <li>Treatment and session history</li>
                                    <li>Prescribed exercise plans &amp; rehabilitation goals</li>
                                    <li>Progress measurements, charts &amp; recovery graphs</li>
                                    <li>Digital progress reports and recommendations</li>
                                </ul>
                                <p class="mb-0">Patients have the option to securely download or share their digital progress reports with their physician or caregiver.</p>
                            </div>
                        </div>

                        {{-- Section 12 --}}
                        <div class="pp-section" id="sec-12">
                            <div class="pp-sec-num">12</div>
                            <h2 class="pp-sec-title">Third-Party Service Providers</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii engages trusted service partners to maintain and deliver our services. These include:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="pp-list small">
                                            <li>Payment gateways (e.g., <strong>Razorpay</strong>)</li>
                                            <li>Secure cloud hosting &amp; database providers</li>
                                            <li>SMS and OTP verification gateways</li>
                                            <li>Email and notification services</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="pp-list small">
                                            <li>WhatsApp &amp; communication APIs</li>
                                            <li>Mapping and geocoding services</li>
                                            <li>Platform security and error monitoring tools</li>
                                            <li>Professional technology vendors</li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">Third parties process data strictly on our instructions and under confidentiality and data protection obligations.</p>
                            </div>
                        </div>

                        {{-- Section 13 --}}
                        <div class="pp-section" id="sec-13">
                            <div class="pp-sec-num">13</div>
                            <h2 class="pp-sec-title">Legal and Regulatory Disclosures</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii may disclose personal information where reasonably necessary or legally required to:</p>
                                <ul class="pp-list">
                                    <li>Comply with applicable statutory laws, court orders, or regulations</li>
                                    <li>Respond to lawful government or law enforcement requests</li>
                                    <li>Protect the vital safety and health interests of patients and therapists</li>
                                    <li>Investigate fraud, security breaches, or platform violations</li>
                                    <li>Protect the legal rights, property, or safety of PhysioPii</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Section 14 --}}
                        <div class="pp-section" id="sec-14">
                            <div class="pp-sec-num">14</div>
                            <h2 class="pp-sec-title">Marketing Communications</h2>
                            <div class="pp-sec-body">
                                <p>With your consent where required, PhysioPii may occasionally share promotional updates, rehabilitation health tips, seasonal package offers, or platform announcements.</p>
                                <p class="mb-0">
                                    Users can opt out of marketing communications at any time. You will continue to receive critical transactional messages such as booking confirmations, OTPs, and payment receipts.
                                </p>
                            </div>
                        </div>

                        {{-- Section 15 --}}
                        <div class="pp-section" id="sec-15">
                            <div class="pp-sec-num">15</div>
                            <h2 class="pp-sec-title">Cookies, SDKs and Similar Technologies</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii web and mobile applications may utilize cookies, SDKs, and session tokens for:</p>
                                <ul class="pp-list">
                                    <li>Secure login authentication and session maintenance</li>
                                    <li>Security, rate limiting, and fraud prevention</li>
                                    <li>Performance analytics and app stability monitoring</li>
                                    <li>Personalization and preference memory</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Section 16 --}}
                        <div class="pp-section" id="sec-16">
                            <div class="pp-sec-num">16</div>
                            <h2 class="pp-sec-title">Rehabilitation Progress Data</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii Go provides a clinical rehabilitation progress tracking framework, recording:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="pp-list small">
                                            <li>Pain ratings (VAS scale)</li>
                                            <li>Range of motion &amp; joint mobility</li>
                                            <li>Muscle strength and motor control</li>
                                            <li>Balance and functional mobility</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="pp-list small">
                                            <li>Walking tolerance &amp; gait parameters</li>
                                            <li>Exercise adherence &amp; completion</li>
                                            <li>Clinical outcome measures &amp; therapist notes</li>
                                            <li>Session completion dates and recovery graphs</li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">This data is accessible only to the patient and authorized treating physiotherapist.</p>
                            </div>
                        </div>

                        {{-- Section 17 --}}
                        <div class="pp-section" id="sec-17">
                            <div class="pp-sec-num">17</div>
                            <h2 class="pp-sec-title">Data Security</h2>
                            <div class="pp-sec-body">
                                <p>We employ multi-layered technical and organizational safeguards to protect your personal and medical information against unauthorized access, loss, misuse, or alteration:</p>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <i class="fas fa-lock text-teal mr-2"></i> <strong>Encrypted Transmission:</strong> SSL/TLS 256-bit encryption for all data in transit.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <i class="fas fa-user-shield text-teal mr-2"></i> <strong>Role-Based Access:</strong> Strict role-based permission controls.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <i class="fas fa-server text-teal mr-2"></i> <strong>Secure Cloud Infrastructure:</strong> ISO-certified server environments with firewalls.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <i class="fas fa-database text-teal mr-2"></i> <strong>Backups &amp; Monitoring:</strong> Automated daily backups and real-time monitoring.
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted small">While we implement rigorous security measures, no digital transmission or electronic storage is 100% immune from potential vulnerability.</p>
                            </div>
                        </div>

                        {{-- Section 18 --}}
                        <div class="pp-section" id="sec-18">
                            <div class="pp-sec-num">18</div>
                            <h2 class="pp-sec-title">Data Retention</h2>
                            <div class="pp-sec-body">
                                <p>PhysioPii retains personal information for as long as necessary to:</p>
                                <ul class="pp-list">
                                    <li>Provide continuous healthcare and rehabilitation services</li>
                                    <li>Maintain medical treatment, session, and booking records</li>
                                    <li>Comply with applicable legal, statutory, accounting, and tax requirements</li>
                                    <li>Resolve disputes, prevent fraud, and establish or defend legal claims</li>
                                </ul>
                                <p class="mb-0">When information is no longer needed, it is securely deleted, anonymized, or purged from active systems.</p>
                            </div>
                        </div>

                        {{-- Section 19: Account & Data Deletion --}}
                        <div class="pp-section highlight-sec" id="sec-19">
                            <div class="pp-sec-num text-danger">19</div>
                            <h2 class="pp-sec-title text-danger"><i class="fas fa-user-slash mr-2"></i> Account and Data Deletion</h2>
                            <div class="pp-sec-body">
                                <p class="lead" style="font-size: 16px; font-weight: 600; color: #1e293b;">
                                    Account deletion requests are handled directly by the <strong>PhysioPii Administration Team</strong>.
                                </p>
                                <p>
                                    Users who wish to request permanent deletion of their <strong>PhysioPii Go</strong> account and associated personal data can submit a request through any of the following channels:
                                </p>

                                <div class="row my-3">
                                    <div class="col-md-6 mb-3">
                                        <div class="pp-deletion-card">
                                            <div class="pp-del-icon"><i class="fas fa-envelope"></i></div>
                                            <div class="pp-del-title">By Email</div>
                                            <a href="mailto:contact@physiopii.in?subject=Account%20Deletion%20Request" class="pp-del-link">contact@physiopii.in</a>
                                            <div class="pp-del-note">Please use subject: <strong>&ldquo;Account Deletion Request&rdquo;</strong></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="pp-deletion-card">
                                            <div class="pp-del-icon"><i class="fas fa-phone-alt"></i></div>
                                            <div class="pp-del-title">By Phone Helpline</div>
                                            <a href="tel:+918855088426" class="pp-del-link">+91 8855088426</a>
                                            <div class="pp-del-note">Call our administration support desk directly</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pp-timeline-box">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-stopwatch text-teal mr-2 fa-lg"></i>
                                        <strong>30-Day Processing Commitment</strong>
                                    </div>
                                    <p class="mb-0 text-muted small">
                                        When submitting a deletion request, users may be asked to provide identifying details (e.g., registered phone number or email) to verify account ownership. After receiving and validating the request, PhysioPii will process the request and delete or anonymize applicable personal information from active systems within <strong>30 days</strong>, subject to data that must be retained under applicable statutory law, medical record guidelines, financial accounting regulations, or dispute resolution requirements.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Section 20 --}}
                        <div class="pp-section" id="sec-20">
                            <div class="pp-sec-num">20</div>
                            <h2 class="pp-sec-title">Your Privacy Rights</h2>
                            <div class="pp-sec-body">
                                <p>Subject to applicable law, users have the right to:</p>
                                <ul class="pp-list">
                                    <li>Request confirmation and information regarding data processing</li>
                                    <li>Request access to personal and health data stored with us</li>
                                    <li>Request correction or updating of inaccurate or outdated information</li>
                                    <li>Request erasure or deletion of personal data where legally applicable</li>
                                    <li>Withdraw consent where processing was based on prior consent</li>
                                    <li>Raise a grievance or inquiry with our Grievance Officer</li>
                                </ul>
                                <p class="mb-0">To exercise any of these rights, contact the PhysioPii Administration Team at <a href="mailto:contact@physiopii.in">contact@physiopii.in</a>.</p>
                            </div>
                        </div>

                        {{-- Section 21 --}}
                        <div class="pp-section" id="sec-21">
                            <div class="pp-sec-num">21</div>
                            <h2 class="pp-sec-title">Children's Privacy</h2>
                            <div class="pp-sec-body">
                                <p>
                                    PhysioPii Go is not directed toward children under 13 without parental or guardian consent and involvement.
                                </p>
                                <p class="mb-0">
                                    Where pediatric physiotherapy or rehabilitation services are booked for a minor, the parent or legal guardian must provide the requisite consent, booking details, and supervision.
                                </p>
                            </div>
                        </div>

                        {{-- Section 22 --}}
                        <div class="pp-section" id="sec-22">
                            <div class="pp-sec-num">22</div>
                            <h2 class="pp-sec-title">Changes to This Privacy Policy</h2>
                            <div class="pp-sec-body">
                                <p>
                                    PhysioPii may update this Privacy Policy from time to time to reflect modifications in our services, technology, legal requirements, or privacy practices.
                                </p>
                                <p class="mb-0">
                                    When changes are published, we will update the <strong>&ldquo;Last Updated&rdquo;</strong> date at the beginning of this policy. Users are encouraged to review this Privacy Policy periodically.
                                </p>
                            </div>
                        </div>

                        {{-- Section 23: Contact & Grievance --}}
                        <div class="pp-section" id="sec-23">
                            <div class="pp-sec-num">23</div>
                            <h2 class="pp-sec-title">Contact and Grievance Redressal</h2>
                            <div class="pp-sec-body">
                                <p>For privacy-related questions, data access requests, complaints, account deletion, or grievance redressal, please reach out to our dedicated privacy desk:</p>

                                <div class="pp-contact-card mt-3">
                                    <h4 class="pp-contact-head"><i class="fas fa-headset mr-2 text-teal"></i> PhysioPii Privacy &amp; Support Team</h4>
                                    <div class="row mt-3">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <div class="pp-contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <div>
                                                    <span class="label">Email Address</span>
                                                    <a href="mailto:contact@physiopii.in">contact@physiopii.in</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <div class="pp-contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <div>
                                                    <span class="label">Helpline Number</span>
                                                    <a href="tel:+918855088426">+91 8855088426</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="pp-contact-item">
                                                <i class="fas fa-globe"></i>
                                                <div>
                                                    <span class="label">Official Website</span>
                                                    <a href="https://physiopii.in" target="_blank">https://physiopii.in</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top text-center text-muted small">
                                    <strong>PhysioPii Go</strong> &bull; Package Name: <code>com.patient.physiopii</code> &bull; Effective: September 22, 2026
                                </div>
                            </div>
                        </div>

                    </div>{{-- /pp-article-card --}}

                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

</div>{{-- /main-wrapper --}}

<style>
/* ── PRIVACY POLICY STYLING ── */
:root {
    --pp-primary: #0c6978;
    --pp-primary-light: #eef8f9;
    --pp-dark: #0f172a;
    --pp-text: #334155;
    --pp-muted: #64748b;
    --pp-border: #e2e8f0;
}

.text-teal { color: var(--pp-primary) !important; }

/* Hero */
.pp-hero {
    background: linear-gradient(135deg, #094e5a 0%, #0c6978 60%, #178091 100%);
    color: #fff;
    padding: 50px 0 45px;
    position: relative;
    overflow: hidden;
}
.pp-hero::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.pp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0 0 16px;
    font-size: 13.5px;
}
.pp-breadcrumb a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: color 0.2s;
}
.pp-breadcrumb a:hover { color: #fff; }
.pp-breadcrumb .separator {
    color: rgba(255,255,255,0.4);
    font-size: 11px;
}
.pp-breadcrumb .active {
    color: #fff;
    font-weight: 600;
}
.pp-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 700;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    margin-bottom: 12px;
}
.pp-hero-title {
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin: 0 0 10px;
    line-height: 1.2;
}
.pp-hero-desc {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
    margin: 0;
    max-width: 650px;
    line-height: 1.55;
}

/* Meta Card in Hero */
.pp-meta-card {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 14px;
    padding: 18px 20px;
}
.pp-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    font-size: 13px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
}
.pp-meta-row:last-child { border-bottom: none; }
.pp-meta-label {
    color: rgba(255,255,255,0.85);
    display: flex;
    align-items: center;
    gap: 6px;
}
.pp-meta-val {
    font-weight: 700;
    color: #fff;
}
.pp-meta-val.code {
    font-family: monospace;
    font-size: 12px;
    background: rgba(0,0,0,0.2);
    padding: 2px 6px;
    border-radius: 4px;
}
.pp-meta-link {
    color: #a7f3d0;
    font-weight: 700;
    text-decoration: none;
}
.pp-meta-link:hover { text-decoration: underline; color: #fff; }

/* Sticky Table of Contents */
.pp-toc-wrapper {
    background: #fff;
    border: 1px solid var(--pp-border);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    overflow: hidden;
}
.pp-toc-header {
    background: var(--pp-primary);
    color: #fff;
    padding: 14px 18px;
    font-weight: 700;
    font-size: 14.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pp-toc-list {
    max-height: calc(100vh - 170px);
    overflow-y: auto;
    padding: 8px 0;
}
.pp-toc-list::-webkit-scrollbar { width: 4px; }
.pp-toc-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.pp-toc-item {
    display: block;
    padding: 7px 18px;
    color: var(--pp-text);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.15s;
    border-left: 3px solid transparent;
}
.pp-toc-item:hover {
    background: var(--pp-primary-light);
    color: var(--pp-primary);
    border-left-color: var(--pp-primary);
    font-weight: 600;
}
.pp-toc-item.highlight {
    color: #dc2626;
    font-weight: 600;
}
.pp-toc-item.highlight:hover {
    background: #fef2f2;
    border-left-color: #dc2626;
}

/* Article Card */
.pp-article-card {
    background: #fff;
    border: 1px solid var(--pp-border);
    border-radius: 16px;
    padding: 36px 40px;
    box-shadow: 0 6px 24px rgba(12,105,120,0.05);
}

/* Sections */
.pp-section {
    position: relative;
    padding-bottom: 36px;
    margin-bottom: 36px;
    border-bottom: 1px solid var(--pp-border);
}
.pp-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.pp-section.highlight-sec {
    background: #fff8f8;
    border: 1.5px dashed #f87171;
    border-radius: 12px;
    padding: 24px 24px 20px;
}
.pp-sec-num {
    font-size: 13px;
    font-weight: 800;
    color: var(--pp-primary);
    letter-spacing: 1px;
    margin-bottom: 4px;
    text-transform: uppercase;
}
.pp-sec-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--pp-dark);
    margin-bottom: 16px;
    line-height: 1.3;
}
.pp-sub-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--pp-primary);
    margin-top: 20px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pp-sec-body {
    color: var(--pp-text);
    font-size: 14.5px;
    line-height: 1.7;
}
.pp-sec-body p {
    margin-bottom: 12px;
}

/* Custom Lists */
.pp-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 16px;
}
.pp-list li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 6px;
    font-size: 14px;
    color: var(--pp-text);
}
.pp-list li::before {
    content: "•";
    position: absolute;
    left: 4px;
    top: 0;
    color: var(--pp-primary);
    font-weight: bold;
    font-size: 18px;
    line-height: 18px;
}
.pp-list.small li {
    font-size: 13px;
    margin-bottom: 4px;
}

/* Callouts & Alert Boxes */
.pp-callout {
    background: #f8fafd;
    border-left: 4px solid var(--pp-primary);
    padding: 16px 20px;
    border-radius: 0 8px 8px 0;
    margin: 16px 0;
}
.pp-callout-title {
    font-weight: 700;
    color: var(--pp-dark);
    font-size: 14.5px;
    margin-bottom: 8px;
}
.pp-alert-box {
    border-radius: 10px;
    padding: 16px 20px;
    margin: 16px 0;
    font-size: 13.5px;
}
.pp-alert-box.alert-warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
}
.pp-alert-box.alert-info {
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    color: #115e59;
}

/* Feature Boxes */
.pp-feature-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 20px;
}
.pp-feature-box h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--pp-dark);
    margin-bottom: 12px;
}

/* Account Deletion Card */
.pp-deletion-card {
    background: #fff;
    border: 1px solid #fecaca;
    border-radius: 10px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(220,38,38,0.06);
    transition: transform 0.2s;
}
.pp-deletion-card:hover { transform: translateY(-2px); }
.pp-del-icon {
    width: 44px;
    height: 44px;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 8px;
}
.pp-del-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.pp-del-link {
    display: block;
    font-size: 16px;
    font-weight: 800;
    color: #dc2626;
    text-decoration: none;
    margin: 4px 0;
}
.pp-del-link:hover { text-decoration: underline; color: #b91c1c; }
.pp-del-note {
    font-size: 12px;
    color: #64748b;
}

.pp-timeline-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
}

/* Contact Card Section 23 */
.pp-contact-card {
    background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
    border: 1px solid #99f6e4;
    border-radius: 12px;
    padding: 24px;
}
.pp-contact-head {
    font-size: 18px;
    font-weight: 800;
    color: var(--pp-primary);
    margin: 0;
}
.pp-contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.pp-contact-item i {
    width: 40px;
    height: 40px;
    background: #fff;
    border: 1px solid #99f6e4;
    color: var(--pp-primary);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.pp-contact-item .label {
    display: block;
    font-size: 11.5px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.4px;
}
.pp-contact-item a {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--pp-primary);
    text-decoration: none;
}
.pp-contact-item a:hover { text-decoration: underline; }

/* Responsive adjustments */
@media (max-width: 991px) {
    .pp-hero-title { font-size: 28px; }
    .pp-article-card { padding: 24px 20px; }
    .pp-sec-title { font-size: 19px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for TOC links
    const tocLinks = document.querySelectorAll('.pp-toc-item, #mobileTOC a');
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = 90;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Active state highlighting on scroll
    const sections = document.querySelectorAll('.pp-section');
    const navItems = document.querySelectorAll('.pp-toc-item');
    window.addEventListener('scroll', function() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 120;
            if (pageYOffset >= sectionTop) {
                current = '#' + section.getAttribute('id');
            }
        });
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === current) {
                item.classList.add('active');
            }
        });
    });
});
</script>
@endsection