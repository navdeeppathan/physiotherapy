@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }
a { text-decoration: none; color: inherit; }

.dp-page { min-height: 100vh; }

/* Breadcrumb */
.dp-breadcrumb {
    background: linear-gradient(135deg, #0c4a6e, #0369a1);
    padding: 20px 0;
    position: relative;
}
.dp-breadcrumb::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='20' cy='20' r='20'/%3E%3C/g%3E%3C/svg%3E") repeat;
}
.dp-bc-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; z-index: 1;
}
.dp-bc-trail { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,.6); }
.dp-bc-trail a { color: rgba(255,255,255,.7); font-weight: 600; }
.dp-bc-trail a:hover { color: #fff; }
.dp-bc-sep { color: rgba(255,255,255,.3); }
.dp-bc-title { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.03em; }

/* Layout */
.dp-body { max-width: 1280px; margin: 0 auto; padding: 32px 24px 56px; display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

/* ── SIDEBAR ── */
.dp-sidebar { position: sticky; top: 88px; display: flex; flex-direction: column; gap: 16px; }

.dp-profile-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
}
.dp-profile-banner {
    height: 80px;
    background: linear-gradient(135deg, #0369a1, #0ea5e9);
    position: relative;
}
.dp-profile-av-wrap {
    position: absolute;
    bottom: -40px; left: 50%;
    transform: translateX(-50%);
}
.dp-profile-av {
    width: 80px; height: 80px;
    border-radius: 50%;
    border: 4px solid #fff;
    object-fit: cover;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
}
.dp-profile-av-placeholder {
    width: 80px; height: 80px;
    border-radius: 50%;
    border: 4px solid #fff;
    background: linear-gradient(135deg, #0ea5e9, #38bdf8);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 900; color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
}

.dp-profile-body { padding: 52px 20px 24px; text-align: center; }
.dp-profile-name { font-size: 18px; font-weight: 800; color: #0f172a; letter-spacing: -.02em; }
.dp-profile-spec { font-size: 13px; color: #0ea5e9; font-weight: 600; margin-top: 4px; }
.dp-profile-rating {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fef3c7; color: #d97706;
    border-radius: 50px; padding: 4px 12px;
    font-size: 13px; font-weight: 800;
    margin-top: 10px;
}
.dp-profile-rating i { font-size: 12px; }

.dp-divider { height: 1px; background: #f1f5f9; margin: 16px 0; }

.dp-info-list { display: flex; flex-direction: column; gap: 12px; }
.dp-info-item { display: flex; align-items: flex-start; gap: 12px; }
.dp-info-icon { width: 34px; height: 34px; border-radius: 9px; background: #e0f2fe; color: #0ea5e9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 13px; }
.dp-info-lbl { font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; }
.dp-info-val { font-size: 14px; color: #0f172a; font-weight: 600; margin-top: 1px; }

.dp-home-badge {
    display: flex; align-items: center; gap: 7px;
    background: #d1fae5; color: #065f46;
    border-radius: 10px; padding: 9px 14px;
    font-size: 13px; font-weight: 700;
    margin-top: 4px;
}
.dp-home-badge i { font-size: 14px; }

.dp-book-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, #0ea5e9, #38bdf8);
    color: #fff; border: none; border-radius: 14px;
    font-size: 15px; font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(14,165,233,.35);
    transition: all .2s;
    margin-top: 8px;
}
.dp-book-btn:hover { background: linear-gradient(135deg, #0284c7, #0ea5e9); box-shadow: 0 12px 32px rgba(14,165,233,.45); transform: translateY(-1px); }

/* ── MAIN ── */
.dp-main { display: flex; flex-direction: column; gap: 20px; }

/* Stats row */
.dp-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
.dp-stat {
    background: #fff; border: 1.5px solid #e2e8f0; border-radius: 16px;
    padding: 20px; text-align: center;
    transition: all .2s;
    position: relative; overflow: hidden;
}
.dp-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:16px 16px 0 0; }
.dp-stat.s0::before { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
.dp-stat.s1::before { background: linear-gradient(90deg, #10b981, #34d399); }
.dp-stat.s2::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.dp-stat:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
.dp-stat-val { font-size: 30px; font-weight: 900; color: #0f172a; letter-spacing: -.05em; }
.dp-stat-lbl { font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 600; }

/* Tab card */
.dp-card { background: #fff; border-radius: 20px; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 16px rgba(0,0,0,.04); overflow: hidden; }
.dp-tabs { display: flex; border-bottom: 1px solid #f1f5f9; padding: 16px 20px 0; gap: 4px; overflow-x: auto; scrollbar-width: none; }
.dp-tabs::-webkit-scrollbar { display: none; }
.dp-tab {
    padding: 9px 16px; border-radius: 10px 10px 0 0;
    font-size: 13.5px; font-weight: 600; color: #94a3b8;
    cursor: pointer; border: none; background: transparent;
    transition: all .18s; white-space: nowrap;
    border-bottom: 2px solid transparent; margin-bottom: -1px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.dp-tab:hover { color: #475569; background: #f8fafc; }
.dp-tab.active { color: #0ea5e9; border-bottom-color: #0ea5e9; background: #f0f9ff; font-weight: 700; }

.dp-tab-pane { display: none; padding: 28px 28px; }
.dp-tab-pane.active { display: block; }

.dp-tab-title { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 9px; }
.dp-tab-title i { font-size: 15px; color: #0ea5e9; }
.dp-tab-text { font-size: 14.5px; color: #475569; line-height: 1.8; }

/* Reviews */
.dp-review-item {
    display: flex; gap: 16px;
    padding: 20px 0; border-bottom: 1px solid #f1f5f9;
}
.dp-review-item:last-child { border-bottom: none; padding-bottom: 0; }
.dp-review-av {
    width: 48px; height: 48px; border-radius: 50%;
    object-fit: cover; flex-shrink: 0;
    border: 2px solid #e0f2fe;
}
.dp-review-av-placeholder {
    width: 48px; height: 48px; border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #38bdf8);
    color: #fff; font-weight: 800; font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dp-review-name { font-size: 14px; font-weight: 800; color: #0f172a; }
.dp-review-stars { color: #f59e0b; font-size: 13px; letter-spacing: 1.5px; margin: 3px 0; }
.dp-review-date { font-size: 12px; color: #94a3b8; }
.dp-review-text { font-size: 14px; color: #475569; line-height: 1.7; margin-top: 8px; }

.dp-empty { text-align: center; padding: 40px 20px; color: #94a3b8; }
.dp-empty i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block; }
.dp-empty p { font-size: 15px; font-weight: 600; color: #64748b; }

@media (max-width: 1024px) {
    .dp-body { grid-template-columns: 1fr; }
    .dp-sidebar { position: static; }
    .dp-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 640px) {
    .dp-body { padding: 16px 14px 32px; }
    .dp-stats { grid-template-columns: 1fr; }
}
</style>

<div class="dp-page">
    @include('layouts.header')

    <div class="dp-breadcrumb">
        <div class="dp-bc-inner">
            <div class="dp-bc-trail">
                <a href="/">Home</a>
                <span class="dp-bc-sep">/</span>
                <span>Doctor Profile</span>
            </div>
            <div class="dp-bc-title">Dr. {{ $doctor->name }}</div>
        </div>
    </div>

    <div class="dp-body">

        {{-- SIDEBAR --}}
        <aside class="dp-sidebar">
            <div class="dp-profile-card">
                <div class="dp-profile-banner"></div>
                <div class="dp-profile-av-wrap">
                    @if($doctor->profile_img)
                        <img src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}" alt="{{ $doctor->name }}" class="dp-profile-av">
                    @else
                        <div class="dp-profile-av-placeholder">{{ strtoupper(substr($doctor->name,0,1)) }}</div>
                    @endif
                </div>
                <div class="dp-profile-body">
                    <div class="dp-profile-name">Dr. {{ $doctor->name }}</div>
                    <div class="dp-profile-spec">{{ optional(optional($doctor->profile)->specializationdata)->name ?? 'Physiotherapist' }}</div>
                    <div class="dp-profile-rating">
                        <i class="fa-solid fa-star"></i> {{ number_format($avgRating,1) }}
                    </div>

                    <div class="dp-divider"></div>

                    <div class="dp-info-list">
                        <div class="dp-info-item">
                            <div class="dp-info-icon"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <div class="dp-info-lbl">Experience</div>
                                <div class="dp-info-val">{{ optional($doctor->profile)->experience_years }} Years</div>
                            </div>
                        </div>
                        <div class="dp-info-item">
                            <div class="dp-info-icon"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <div class="dp-info-lbl">Phone</div>
                                <div class="dp-info-val">{{ $doctor->phone }}</div>
                            </div>
                        </div>
                        <div class="dp-info-item">
                            <div class="dp-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <div class="dp-info-lbl">Location</div>
                                <div class="dp-info-val">{{ $doctor->address ?? optional($doctor->profile)->clinic_address ?? '—' }}</div>
                            </div>
                        </div>
                    </div>

                    @if(optional($doctor->profile)->home_visit_available)
                        <div class="dp-divider"></div>
                        <div class="dp-home-badge">
                            <i class="fa-solid fa-house-medical-circle-check"></i>
                            Home Visit Available
                        </div>
                    @endif

                    <div class="dp-divider"></div>

                    <a href="{{ route('doctor.booking', $doctor->id) }}" class="dp-book-btn">
                        <i class="fa-solid fa-calendar-check"></i>
                        Book Appointment
                    </a>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="dp-main">

            {{-- Stats --}}
            <div class="dp-stats">
                <div class="dp-stat s0">
                    <div class="dp-stat-val">{{ optional($doctor->profile)->experience_years ?? 0 }}</div>
                    <div class="dp-stat-lbl">Years Experience</div>
                </div>
                <div class="dp-stat s1">
                    <div class="dp-stat-val">{{ $totalReviews }}</div>
                    <div class="dp-stat-lbl">Patient Reviews</div>
                </div>
                <div class="dp-stat s2">
                    <div class="dp-stat-val">{{ number_format($avgRating,1) }}★</div>
                    <div class="dp-stat-lbl">Avg. Rating</div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="dp-card">
                <div class="dp-tabs">
                    <button class="dp-tab active" onclick="dpTab('about',this)">About</button>
                    <button class="dp-tab" onclick="dpTab('qualification',this)">Qualification</button>
                    <button class="dp-tab" onclick="dpTab('career',this)">Career</button>
                    <button class="dp-tab" onclick="dpTab('highlights',this)">Highlights</button>
                    <button class="dp-tab" onclick="dpTab('reviews',this)">Reviews ({{ $totalReviews }})</button>
                </div>

                <div class="dp-tab-pane active" id="dp-about">
                    <div class="dp-tab-title"><i class="fa-solid fa-user-doctor"></i> Biography</div>
                    <p class="dp-tab-text">{!! nl2br(e(optional($doctor->profile)->bio ?? 'No biography available.')) !!}</p>
                </div>

                <div class="dp-tab-pane" id="dp-qualification">
                    <div class="dp-tab-title"><i class="fa-solid fa-graduation-cap"></i> Qualification</div>
                    <p class="dp-tab-text">{!! nl2br(e(optional($doctor->profile)->qualification ?? 'N/A')) !!}</p>
                </div>

                <div class="dp-tab-pane" id="dp-career">
                    <div class="dp-tab-title"><i class="fa-solid fa-briefcase"></i> Career Path</div>
                    <p class="dp-tab-text">{!! nl2br(e(optional($doctor->profile)->career_path ?? 'N/A')) !!}</p>
                </div>

                <div class="dp-tab-pane" id="dp-highlights">
                    <div class="dp-tab-title"><i class="fa-solid fa-trophy"></i> Highlights</div>
                    <p class="dp-tab-text">{!! nl2br(e(optional($doctor->profile)->highlights ?? 'N/A')) !!}</p>
                </div>

                <div class="dp-tab-pane" id="dp-reviews">
                    <div class="dp-tab-title"><i class="fa-solid fa-star"></i> Patient Reviews</div>
                    @forelse($doctor->receivedReviews as $review)
                        <div class="dp-review-item">
                            @if($review->patient->profile_img)
                                <img src="{{ str_contains($review->patient->profile_img, '/') ? asset($review->patient->profile_img) : asset('uploads/profile/'.$review->patient->profile_img) }}" alt="{{ $review->patient->name }}" class="dp-review-av">
                            @else
                                <div class="dp-review-av-placeholder">{{ strtoupper(substr($review->patient->name,0,1)) }}</div>
                            @endif
                            <div style="flex:1">
                                <div class="dp-review-name">{{ $review->patient->name }}</div>
                                <div class="dp-review-stars">{{ str_repeat('★',$review->rating) }}{{ str_repeat('☆',5-$review->rating) }}</div>
                                <div class="dp-review-date">{{ $review->created_at->format('d M Y') }}</div>
                                <p class="dp-review-text">{{ $review->review }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="dp-empty">
                            <i class="fa-regular fa-star"></i>
                            <p>No reviews yet for this doctor.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</div>

<script>
function dpTab(id, btn) {
    document.querySelectorAll('.dp-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.dp-tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('dp-' + id).classList.add('active');
}
</script>

@endsection
