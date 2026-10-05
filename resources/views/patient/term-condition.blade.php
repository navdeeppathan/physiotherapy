@extends('layouts.app')

@section('title', 'Terms and Conditions — PhysioPii Healthcare | Platform Terms & Service Agreement')
@section('meta_description', 'Official Terms and Conditions for PhysioPii Healthcare. Read our terms of service, appointment booking policies, payment, cancellation, and user agreements.')
@section('meta_keywords', 'PhysioPii terms and conditions, terms of service, patient agreement, physiotherapy booking policy, cancellation policy, medical disclaimer, physiopii.in')

@section('content')
<div class="main-wrapper">

    @include('layouts.header')

    {{-- ── HERO / BREADCRUMB ── --}}
    <section class="tc-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="tc-breadcrumb">
                            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                            <li class="separator"><i class="fas fa-chevron-right"></i></li>
                            <li class="active" aria-current="page">Terms and Conditions</li>
                        </ol>
                    </nav>
                    <div class="tc-badge">
                        <i class="fas fa-file-contract"></i> Official Legal &amp; User Agreement
                    </div>
                    <h1 class="tc-hero-title">Terms &amp; Conditions</h1>
                    <p class="tc-hero-desc">
                        PhysioPii Healthcare &mdash; Transparent, fair, and comprehensive terms governing your access to our website, mobile applications, and clinical coordination services.
                    </p>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="tc-meta-card">
                        <div class="tc-meta-row">
                            <span class="tc-meta-label"><i class="far fa-calendar-check"></i> Effective Date:</span>
                            <span class="tc-meta-val">September 22, 2026</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-meta-label"><i class="fas fa-history"></i> Last Updated:</span>
                            <span class="tc-meta-val">September 22, 2026</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-meta-label"><i class="fas fa-mobile-alt"></i> Platform:</span>
                            <span class="tc-meta-val">Web &amp; PhysioPii Go</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-meta-label"><i class="fas fa-globe"></i> Official Portal:</span>
                            <a href="https://physiopii.in" target="_blank" class="tc-meta-link">physiopii.in</a>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-meta-label"><i class="fas fa-headset"></i> Support Hotline:</span>
                            <a href="tel:+918855088426" class="tc-meta-link">+91 8855088426</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── MAIN CONTENT SECTION ── --}}
    <section class="tc-body-section py-5">
        <div class="container">
            <div class="row">

                {{-- Left Sticky TOC --}}
                <div class="col-lg-4 col-xl-3 d-none d-lg-block">
                    <div class="tc-toc-wrapper sticky-top" style="top: 90px; z-index: 10;">
                        <div class="tc-toc-header">
                            <i class="fas fa-list-ul"></i> Table of Contents
                        </div>
                        <div class="tc-toc-list">
                            <a href="#sec-1" class="tc-toc-item">1. Acceptance of Terms</a>
                            <a href="#sec-2" class="tc-toc-item">2. Platform Role &amp; Model</a>
                            <a href="#sec-3" class="tc-toc-item highlight">3. Medical Disclaimer</a>
                            <a href="#sec-4" class="tc-toc-item">4. Eligibility &amp; Accounts</a>
                            <a href="#sec-5" class="tc-toc-item">5. Booking &amp; Scheduling</a>
                            <a href="#sec-6" class="tc-toc-item">6. Fees &amp; Payments</a>
                            <a href="#sec-7" class="tc-toc-item highlight">7. Cancellations &amp; Refunds</a>
                            <a href="#sec-8" class="tc-toc-item">8. Patient Responsibilities</a>
                            <a href="#sec-9" class="tc-toc-item">9. Home Visit Guidelines</a>
                            <a href="#sec-10" class="tc-toc-item">10. Clinician Independence</a>
                            <a href="#sec-11" class="tc-toc-item">11. Digital Consultations</a>
                            <a href="#sec-12" class="tc-toc-item">12. Data Privacy &amp; Records</a>
                            <a href="#sec-13" class="tc-toc-item">13. Intellectual Property</a>
                            <a href="#sec-14" class="tc-toc-item">14. Ratings &amp; Reviews</a>
                            <a href="#sec-15" class="tc-toc-item">15. Limitation of Liability</a>
                            <a href="#sec-16" class="tc-toc-item">16. Indemnification</a>
                            <a href="#sec-17" class="tc-toc-item">17. Account Termination</a>
                            <a href="#sec-18" class="tc-toc-item">18. Governing Law &amp; Contact</a>
                        </div>
                    </div>
                </div>

                {{-- Terms Content --}}
                <div class="col-lg-8 col-xl-9">
                    <div class="tc-article-card">

                        {{-- Section 1 --}}
                        <div class="tc-section" id="sec-1">
                            <div class="tc-sec-number">Section 01</div>
                            <h2 class="tc-sec-title">Acceptance of Terms</h2>
                            <p class="tc-text">
                                Welcome to <strong>PhysioPii Healthcare</strong> (&ldquo;PhysioPii&rdquo;, &ldquo;we&rdquo;, &ldquo;us&rdquo;, or &ldquo;our&rdquo;). These Terms and Conditions (&ldquo;Terms&rdquo;) constitute a legally binding agreement between you (&ldquo;User&rdquo;, &ldquo;Patient&rdquo;, or &ldquo;you&rdquo;) and PhysioPii Healthcare, governing your access to and use of the website located at <a href="https://physiopii.in" target="_blank">https://physiopii.in</a>, our mobile applications (including PhysioPii Go), and any associated healthcare coordination and booking services (collectively, the &ldquo;Platform&rdquo;).
                            </p>
                            <div class="tc-callout">
                                <div class="tc-callout-title"><i class="fas fa-check-circle text-teal"></i> Explicit Agreement</div>
                                By registering for an account, accessing our portal, browsing specialist profiles, or booking an appointment through PhysioPii, you represent and warrant that you have read, understood, and agreed to be bound by these Terms and our companion <a href="{{ route('privacy.policy') }}">Privacy Policy</a>. If you do not agree to these Terms, you must immediately discontinue using the Platform.
                            </div>
                        </div>

                        {{-- Section 2 --}}
                        <div class="tc-section" id="sec-2">
                            <div class="tc-sec-number">Section 02</div>
                            <h2 class="tc-sec-title">Our Role as a Technology &amp; Clinical Coordination Platform</h2>
                            <p class="tc-text">
                                PhysioPii operates as a digital healthcare discovery, scheduling, and coordination platform designed to facilitate appointments between patients seeking physical rehabilitation and qualified, certified independent physiotherapists and healthcare clinics.
                            </p>
                            <ul class="tc-list">
                                <li><strong>Facilitator Status:</strong> PhysioPii provides the technology infrastructure enabling patients to discover registered specialists, review qualifications, schedule in-clinic and home-visit appointments, submit assessments, and securely process payments.</li>
                                <li><strong>Independent Practitioners:</strong> Unless explicitly stated otherwise, physiotherapists and clinical specialists featured on the Platform operate as independent healthcare professionals. Each clinician maintains autonomous professional and clinical responsibility for their assessment, diagnosis, treatment techniques, and patient care.</li>
                                <li><strong>Credential Screening:</strong> PhysioPii verifies that all practitioners onboarded have provided valid educational degrees (such as BPT, MPT, or equivalent) and registration with competent regional or national councils.</li>
                            </ul>
                        </div>

                        {{-- Section 3 --}}
                        <div class="tc-section highlight-sec" id="sec-3">
                            <div class="tc-sec-number">Section 03</div>
                            <h2 class="tc-sec-title text-danger"><i class="fas fa-exclamation-triangle"></i> Medical Disclaimer &amp; Non-Emergency Notice</h2>
                            <div class="tc-alert-box alert-warning">
                                <strong>EMERGENCY NOTICE:</strong> PhysioPii IS NOT AN EMERGENCY MEDICAL PROVIDER. If you are experiencing severe chest pain, shortness of breath, sudden numbness or paralysis, uncontrolled bleeding, acute neurological symptoms, or any life-threatening condition, immediately dial your local emergency services (such as 112 / 108 in India) or visit the nearest hospital emergency department.
                            </div>
                            <p class="tc-text">
                                The information, articles, guides, exercises, and media content provided on the PhysioPii website are for educational and informational purposes only and do not constitute specific medical advice, formal clinical diagnosis, or a replacement for an individualized clinical assessment by a licensed healthcare professional.
                            </p>
                        </div>

                        {{-- Section 4 --}}
                        <div class="tc-section" id="sec-4">
                            <div class="tc-sec-number">Section 04</div>
                            <h2 class="tc-sec-title">Eligibility, Registration &amp; Account Security</h2>
                            <p class="tc-text">
                                To use our booking and dashboard services, you must be at least 18 years of age and possess the legal capacity to enter into binding agreements. Parents or legal guardians may create accounts and schedule appointments on behalf of minor dependents.
                            </p>
                            <div class="row g-3 my-2">
                                <div class="col-md-6">
                                    <div class="tc-feature-box h-100">
                                        <h5><i class="fas fa-user-shield text-teal"></i> Accurate Credentials</h5>
                                        <p class="small text-muted mb-0">You agree to provide true, accurate, and current contact information (including mobile number and email) during registration and update it promptly when changes occur.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tc-feature-box h-100">
                                        <h5><i class="fas fa-key text-teal"></i> Confidentiality</h5>
                                        <p class="small text-muted mb-0">You are solely responsible for maintaining the confidentiality of your login credentials and for all activities that take place under your account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 5 --}}
                        <div class="tc-section" id="sec-5">
                            <div class="tc-sec-number">Section 05</div>
                            <h2 class="tc-sec-title">Appointment Scheduling: In-Clinic &amp; Home Visits</h2>
                            <p class="tc-text">
                                PhysioPii enables patients to schedule both in-clinic consultations and dedicated at-home rehabilitation sessions:
                            </p>
                            <ul class="tc-list">
                                <li><strong>Real-Time Availability:</strong> Appointment slots displayed on the Platform reflect the clinician&rsquo;s current availability. Once booked and confirmed, a confirmation notification is dispatched via SMS/WhatsApp or Email.</li>
                                <li><strong>In-Clinic Appointments:</strong> Patients are requested to arrive at the designated clinic location at least 10 minutes prior to the scheduled consultation time.</li>
                                <li><strong>Home Visit Sessions:</strong> For home visits, the patient must provide a precise, accessible residential address and contact details. The therapist will arrive with standard portable therapeutic equipment.</li>
                                <li><strong>Delays &amp; Unforeseen Circumstances:</strong> While clinicians strive for punctuality, unexpected traffic, emergency patient care, or weather may cause minor schedule adjustments. The clinician or PhysioPii team will communicate updates promptly.</li>
                            </ul>
                        </div>

                        {{-- Section 6 --}}
                        <div class="tc-section" id="sec-6">
                            <div class="tc-sec-number">Section 06</div>
                            <h2 class="tc-sec-title">Consultation Fees, Billing &amp; Payment Processing</h2>
                            <p class="tc-text">
                                PhysioPii believes in 100% upfront, transparent pricing without hidden charges:
                            </p>
                            <ul class="tc-list">
                                <li><strong>Fee Display:</strong> Every specialist profile lists their clear consultation fee per session, inclusive of applicable taxes, for in-clinic, home visit, or package plans.</li>
                                <li><strong>Payment Gateways:</strong> Online transactions are handled through certified, PCI-DSS compliant Indian payment gateways (such as Razorpay, UPI, credit/debit cards, and Net Banking). PhysioPii never stores sensitive card credentials or CVV numbers on its servers.</li>
                                <li><strong>Invoices &amp; Receipts:</strong> Digital tax invoices and itemized session receipts are automatically generated and made available in your Patient Dashboard for insurance reimbursement claims.</li>
                            </ul>
                        </div>

                        {{-- Section 7 --}}
                        <div class="tc-section highlight-sec" id="sec-7">
                            <div class="tc-sec-number">Section 07</div>
                            <h2 class="tc-sec-title"><i class="fas fa-undo-alt text-teal"></i> Rescheduling, Cancellation &amp; Refund Policy</h2>
                            <p class="tc-text">
                                We understand that health schedules can change unexpectedly. Our cancellation policy is designed to be fair to both patients and visiting clinicians:
                            </p>
                            <div class="tc-feature-box mb-3">
                                <h5><i class="fas fa-clock text-teal"></i> 24-Hour Free Cancellation &amp; Rescheduling</h5>
                                <p class="mb-2">
                                    You may reschedule or cancel any booked consultation with <strong>zero penalty</strong> up to <strong>24 hours prior</strong> to the scheduled appointment start time directly from your dashboard or by contacting our support team.
                                </p>
                            </div>
                            <ul class="tc-list">
                                <li><strong>Cancellations within 24 Hours:</strong> Cancellations made less than 24 hours prior to a session may be subject to a nominal administrative or clinician reservation fee to compensate for the practitioner&rsquo;s reserved time slot.</li>
                                <li><strong>Clinician Cancellation:</strong> If a scheduled clinician is unable to attend due to unforeseen illness or emergency, you will be offered the choice of an immediate rescheduling, a qualified substitute specialist, or a 100% refund.</li>
                                <li><strong>Refund Timelines:</strong> Approved refunds are processed back to the original payment source within 5 to 7 business days in accordance with Indian banking standards.</li>
                            </ul>
                        </div>

                        {{-- Section 8 --}}
                        <div class="tc-section" id="sec-8">
                            <div class="tc-sec-number">Section 08</div>
                            <h2 class="tc-sec-title">Patient Responsibilities &amp; Medical Disclosures</h2>
                            <p class="tc-text">
                                Effective physical therapy relies on open and honest communication. To ensure safe and optimal recovery, the patient agrees to:
                            </p>
                            <ul class="tc-list">
                                <li>Accurately disclose their comprehensive medical history, prior surgeries, cardiac conditions, fractures, allergies, current medications, implants, and pregnancy status.</li>
                                <li>Promptly inform the treating physiotherapist if any exercise, manipulation, or modality causes sharp pain, dizziness, or distress during the session.</li>
                                <li>Adhere to the prescribed home rehabilitation exercise plan and avoid unapproved strenuous activities that could aggravate existing physical conditions.</li>
                            </ul>
                        </div>

                        {{-- Section 9 --}}
                        <div class="tc-section" id="sec-9">
                            <div class="tc-sec-number">Section 09</div>
                            <h2 class="tc-sec-title">Home Visit Safety &amp; Code of Conduct</h2>
                            <p class="tc-text">
                                For treatments provided at a patient&rsquo;s home, the patient and household members agree to provide a safe, respectful, and professional clinical environment:
                            </p>
                            <ul class="tc-list">
                                <li><strong>Safe Environment:</strong> Provide a clean, well-lit, and sufficiently spacious area with adequate ventilation where therapeutic exercises and couch/mat placements can be safely conducted. Domestic pets must be kept secured during treatment.</li>
                                <li><strong>Zero Tolerance for Harassment:</strong> PhysioPii enforces a strict zero-tolerance policy against any form of verbal, physical, sexual, or discriminatory abuse directed toward healthcare providers. Any misconduct will result in immediate termination of the session, forfeiture of fees, and potential reporting to law enforcement authorities.</li>
                                <li><strong>Guardian Presence:</strong> For female patients, pediatric patients, or vulnerable individuals requesting home visits, an adult family member or guardian should be present in the residence during treatment.</li>
                            </ul>
                        </div>

                        {{-- Section 10 --}}
                        <div class="tc-section" id="sec-10">
                            <div class="tc-sec-number">Section 10</div>
                            <h2 class="tc-sec-title">Physiotherapist Independence &amp; Professional Standards</h2>
                            <p class="tc-text">
                                Physiotherapists on the PhysioPii platform exercise independent clinical discretion. Clinicians have the professional right and medical duty to refuse or halt any treatment protocol if, in their clinical judgment, the procedure is medically contraindicated or poses a risk to the patient&rsquo;s well-being.
                            </p>
                        </div>

                        {{-- Section 11 --}}
                        <div class="tc-section" id="sec-11">
                            <div class="tc-sec-number">Section 11</div>
                            <h2 class="tc-sec-title">Digital &amp; Virtual Consultations</h2>
                            <p class="tc-text">
                                When utilizing tele-rehabilitation or video consultation services:
                            </p>
                            <ul class="tc-list">
                                <li>You acknowledge that video consultations possess inherent technological limitations compared to in-person physical palpation and hands-on clinical assessments.</li>
                                <li>You are responsible for maintaining a reliable internet connection, compatible camera, and audio device in a quiet, private space.</li>
                                <li>Neither party may record audio or video during a consultation without the express prior written consent of both the clinician and the patient.</li>
                            </ul>
                        </div>

                        {{-- Section 12 --}}
                        <div class="tc-section" id="sec-12">
                            <div class="tc-sec-number">Section 12</div>
                            <h2 class="tc-sec-title">Data Privacy &amp; Health Records</h2>
                            <p class="tc-text">
                                Your personal and clinical data is governed by our <a href="{{ route('privacy.policy') }}">Privacy Policy</a>. By using the Platform, you consent to the collection, storage, and processing of your personal information, diagnostic assessments, and appointment records in accordance with Indian information technology regulations and healthcare privacy standards.
                            </p>
                        </div>

                        {{-- Section 13 --}}
                        <div class="tc-section" id="sec-13">
                            <div class="tc-sec-number">Section 13</div>
                            <h2 class="tc-sec-title">Intellectual Property Rights</h2>
                            <p class="tc-text">
                                All intellectual property rights in the Platform, including but not limited to the <strong>PhysioPii</strong> name, logo, graphic designs, software source code, illustrations, domain names, and educational articles, are the exclusive property of PhysioPii Healthcare. You may not copy, reverse engineer, reproduce, scrape, or distribute any part of the Platform without our explicit written authorization.
                            </p>
                        </div>

                        {{-- Section 14 --}}
                        <div class="tc-section" id="sec-14">
                            <div class="tc-sec-number">Section 14</div>
                            <h2 class="tc-sec-title">User Reviews &amp; Ratings</h2>
                            <p class="tc-text">
                                Patients who have completed appointments may submit authentic reviews and ratings. You warrant that any feedback you submit is truthful, constructive, and based on your firsthand treatment experience. PhysioPii reserves the right to moderate or remove reviews containing abusive language, profanity, defaming statements, or commercial spam.
                            </p>
                        </div>

                        {{-- Section 15 --}}
                        <div class="tc-section" id="sec-15">
                            <div class="tc-sec-number">Section 15</div>
                            <h2 class="tc-sec-title">Limitation of Liability</h2>
                            <p class="tc-text">
                                To the maximum extent permitted by applicable Indian law:
                            </p>
                            <ul class="tc-list">
                                <li>PhysioPii shall not be liable for any indirect, incidental, punitive, or consequential damages arising from your use of the Platform or services arranged through it.</li>
                                <li>PhysioPii is not liable for medical malpractice, negligence, or diagnostic errors made by independent treating physiotherapists.</li>
                                <li>In any event, our total aggregate liability to you for any claim arising under these Terms shall not exceed the total consultation fees paid by you to PhysioPii for the specific appointment giving rise to the dispute.</li>
                            </ul>
                        </div>

                        {{-- Section 16 --}}
                        <div class="tc-section" id="sec-16">
                            <div class="tc-sec-number">Section 16</div>
                            <h2 class="tc-sec-title">Indemnification</h2>
                            <p class="tc-text">
                                You agree to defend, indemnify, and hold harmless PhysioPii Healthcare, its founders, directors, employees, and affiliates from and against any claims, liabilities, damages, losses, or legal costs arising out of your violation of these Terms, your provision of false medical disclosures, or any unlawful conduct.
                            </p>
                        </div>

                        {{-- Section 17 --}}
                        <div class="tc-section" id="sec-17">
                            <div class="tc-sec-number">Section 17</div>
                            <h2 class="tc-sec-title">Account Termination &amp; Suspension</h2>
                            <p class="tc-text">
                                We reserve the right to suspend or terminate your account and access to the Platform at our sole discretion, without prior notice, if you breach any provision of these Terms, engage in fraudulent transactions, or behave inappropriately toward our healthcare personnel or clinicians.
                            </p>
                        </div>

                        {{-- Section 18 --}}
                        <div class="tc-section" id="sec-18">
                            <div class="tc-sec-number">Section 18</div>
                            <h2 class="tc-sec-title">Governing Law, Dispute Resolution &amp; Contact</h2>
                            <p class="tc-text">
                                These Terms shall be governed by and construed in accordance with the laws of India. Any disputes arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the competent courts in Maharashtra, India.
                            </p>

                            <div class="tc-contact-card mt-4">
                                <h4 class="tc-contact-head mb-3">Questions or Grievances?</h4>
                                <p class="small text-muted mb-4">
                                    If you have questions regarding these Terms or wish to raise a formal grievance, our dedicated legal and grievance support team is ready to assist:
                                </p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="tc-contact-item">
                                            <i class="fas fa-envelope"></i>
                                            <div>
                                                <span class="label">Legal &amp; Support Email</span>
                                                <a href="mailto:contact@physiopii.in">contact@physiopii.in</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="tc-contact-item">
                                            <i class="fas fa-phone-alt"></i>
                                            <div>
                                                <span class="label">Patient Helpline</span>
                                                <a href="tel:+918855088426">+91 8855088426</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="tc-contact-item">
                                            <i class="fas fa-globe"></i>
                                            <div>
                                                <span class="label">Official Website</span>
                                                <a href="https://physiopii.in" target="_blank">physiopii.in</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top text-center text-muted small">
                                <strong>PhysioPii Healthcare</strong> &bull; India &bull; Effective: September 22, 2026
                            </div>
                        </div>

                    </div>{{-- /tc-article-card --}}
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

</div>{{-- /main-wrapper --}}

<style>
/* ── TERMS & CONDITIONS STYLING ── */
:root {
    --tc-primary: #0c6978;
    --tc-primary-light: #eef8f9;
    --tc-dark: #0f172a;
    --tc-text: #334155;
    --tc-muted: #64748b;
    --tc-border: #e2e8f0;
}

.text-teal { color: var(--tc-primary) !important; }

/* Hero */
.tc-hero {
    background: linear-gradient(135deg, #094e5a 0%, #0c6978 60%, #178091 100%);
    color: #fff;
    padding: 50px 0 45px;
    position: relative;
    overflow: hidden;
}
.tc-hero::before {
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
.tc-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0 0 16px;
    font-size: 13.5px;
}
.tc-breadcrumb a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: color 0.2s;
}
.tc-breadcrumb a:hover { color: #fff; }
.tc-breadcrumb .separator {
    color: rgba(255,255,255,0.4);
    font-size: 11px;
}
.tc-breadcrumb .active {
    color: #fff;
    font-weight: 600;
}
.tc-badge {
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
.tc-hero-title {
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin: 0 0 10px;
    line-height: 1.2;
}
.tc-hero-desc {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
    margin: 0;
    max-width: 650px;
    line-height: 1.55;
}

/* Meta Card in Hero */
.tc-meta-card {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 14px;
    padding: 18px 20px;
}
.tc-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    font-size: 13px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
}
.tc-meta-row:last-child { border-bottom: none; }
.tc-meta-label {
    color: rgba(255,255,255,0.85);
    display: flex;
    align-items: center;
    gap: 6px;
}
.tc-meta-val {
    font-weight: 700;
    color: #fff;
}
.tc-meta-link {
    color: #a7f3d0;
    font-weight: 700;
    text-decoration: none;
}
.tc-meta-link:hover { text-decoration: underline; color: #fff; }

/* Sticky Table of Contents */
.tc-toc-wrapper {
    background: #fff;
    border: 1px solid var(--tc-border);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    overflow: hidden;
}
.tc-toc-header {
    background: var(--tc-primary);
    color: #fff;
    padding: 14px 18px;
    font-weight: 700;
    font-size: 14.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.tc-toc-list {
    max-height: calc(100vh - 170px);
    overflow-y: auto;
    padding: 8px 0;
}
.tc-toc-list::-webkit-scrollbar { width: 4px; }
.tc-toc-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.tc-toc-item {
    display: block;
    padding: 7px 18px;
    color: var(--tc-text);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.15s;
    border-left: 3px solid transparent;
}
.tc-toc-item:hover {
    background: var(--tc-primary-light);
    color: var(--tc-primary);
    border-left-color: var(--tc-primary);
    font-weight: 600;
}
.tc-toc-item.active {
    background: var(--tc-primary-light);
    color: var(--tc-primary);
    border-left-color: var(--tc-primary);
    font-weight: 700;
}
.tc-toc-item.highlight {
    color: #b91c1c;
    font-weight: 600;
}
.tc-toc-item.highlight:hover {
    background: #fef2f2;
    border-left-color: #dc2626;
}

/* Article Card */
.tc-article-card {
    background: #fff;
    border: 1px solid var(--tc-border);
    border-radius: 16px;
    padding: 36px 40px;
    box-shadow: 0 6px 24px rgba(12,105,120,0.05);
}

/* Sections */
.tc-section {
    position: relative;
    padding-bottom: 36px;
    margin-bottom: 36px;
    border-bottom: 1px solid var(--tc-border);
}
.tc-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.tc-section.highlight-sec {
    background: #fffbfb;
    border: 1px solid #fee2e2;
    border-radius: 12px;
    padding: 24px;
    margin-top: 20px;
}
.tc-sec-number {
    font-size: 12px;
    font-weight: 800;
    color: var(--tc-primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
}
.tc-sec-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--tc-dark);
    margin: 0 0 16px;
    letter-spacing: -0.3px;
}
.tc-text {
    font-size: 15px;
    color: var(--tc-text);
    line-height: 1.7;
    margin-bottom: 14px;
}
.tc-text a {
    color: var(--tc-primary);
    font-weight: 600;
    text-decoration: underline;
}
.tc-list {
    margin: 12px 0 16px;
    padding-left: 0;
    list-style: none;
}
.tc-list li {
    position: relative;
    padding-left: 22px;
    margin-bottom: 8px;
    font-size: 14.5px;
    line-height: 1.6;
    color: var(--tc-text);
}
.tc-list li::before {
    content: "•";
    position: absolute;
    left: 4px;
    top: 0;
    color: var(--tc-primary);
    font-weight: bold;
    font-size: 18px;
    line-height: 18px;
}

/* Callouts & Alert Boxes */
.tc-callout {
    background: #f8fafd;
    border-left: 4px solid var(--tc-primary);
    padding: 16px 20px;
    border-radius: 0 8px 8px 0;
    margin: 16px 0;
    font-size: 14px;
    line-height: 1.6;
}
.tc-callout-title {
    font-weight: 700;
    color: var(--tc-dark);
    font-size: 14.5px;
    margin-bottom: 8px;
}
.tc-alert-box {
    border-radius: 10px;
    padding: 16px 20px;
    margin: 16px 0;
    font-size: 13.5px;
    line-height: 1.6;
}
.tc-alert-box.alert-warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
}

/* Feature Boxes */
.tc-feature-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 20px;
}
.tc-feature-box h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--tc-dark);
    margin-bottom: 8px;
}

/* Contact Card */
.tc-contact-card {
    background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
    border: 1px solid #99f6e4;
    border-radius: 12px;
    padding: 24px;
}
.tc-contact-head {
    font-size: 18px;
    font-weight: 800;
    color: var(--tc-primary);
    margin: 0;
}
.tc-contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.tc-contact-item i {
    width: 40px;
    height: 40px;
    background: #fff;
    border: 1px solid #99f6e4;
    color: var(--tc-primary);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.tc-contact-item .label {
    display: block;
    font-size: 11.5px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.4px;
}
.tc-contact-item a {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--tc-primary);
    text-decoration: none;
}
.tc-contact-item a:hover { text-decoration: underline; }

/* Responsive adjustments */
@media (max-width: 991px) {
    .tc-hero-title { font-size: 28px; }
    .tc-article-card { padding: 24px 20px; }
    .tc-sec-title { font-size: 19px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for TOC links
    const tocLinks = document.querySelectorAll('.tc-toc-item');
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
    const sections = document.querySelectorAll('.tc-section');
    const navItems = document.querySelectorAll('.tc-toc-item');
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