@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   THEME VARIABLES & BASE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
:root {
    --primary-teal:      #0c6978;
    --primary-teal-dark: #074752;
    --primary-teal-deep: #083c45;
    --primary-teal-sub:  #108598;
    --teal-bg-soft:      #eef8f9;
    --teal-badge-bg:     #e2f4f6;
    --teal-badge-border: #bce5ea;
    --accent-mint:       #2dd4bf;
    --accent-green:      #10b981;
    --gold:              #f59e0b;
    --gold-light:        #fef3c7;
    --ink:               #0f172a;
    --ink-light:         #1e293b;
    --body-text:         #475569;
    --muted-text:        #64748b;
    --light-border:      #e2e8f0;
    --card-bg:           #ffffff;
    --page-bg:           #ffffff;
    --footer-bg:         #09121f;
    --radius-sm:         8px;
    --radius-md:         12px;
    --radius-lg:         18px;
    --radius-xl:         24px;
    --shadow-soft:       0 8px 30px rgba(12, 105, 120, 0.06);
    --shadow-card:       0 4px 20px rgba(15, 23, 42, 0.05);
    --shadow-hover:      0 14px 40px rgba(12, 105, 120, 0.12);
}

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--body-text);
    background-color: var(--page-bg);
    line-height: 1.6;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

.home-container {
    max-width: 1220px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HEADER / NAVBAR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
    padding: 14px 0;
    transition: box-shadow 0.2s;
}

.pth-navbar.scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.pth-nav-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.pth-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.pth-brand-icon {
    width: 38px;
    height: 38px;
    background: var(--primary-teal);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
}

.pth-brand-name {
    font-size: 21px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.03em;
}
.pth-brand-name span {
    color: var(--primary-teal);
}

.pth-nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
    list-style: none;
}

.pth-nav-link {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    transition: color 0.18s;
}

.pth-nav-link:hover,
.pth-nav-link.active {
    color: var(--primary-teal);
}

.pth-nav-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.pth-call-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
}
.pth-call-pill i {
    color: var(--primary-teal);
    font-size: 13px;
}
.pth-call-pill span {
    color: #64748b;
    font-weight: 500;
}

.pth-btn-book {
    background: var(--primary-teal);
    color: #ffffff !important;
    padding: 10px 22px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(12, 105, 120, 0.2);
}

.pth-btn-book:hover {
    background: var(--primary-teal-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(12, 105, 120, 0.3);
}

/* Mobile Toggle */
.pth-menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 22px;
    color: var(--ink);
    cursor: pointer;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HERO SECTION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-hero-section {
    padding: 60px 0 50px;
    background: radial-gradient(circle at 10% 20%, rgba(226, 244, 246, 0.65) 0%, rgba(255, 255, 255, 0) 50%);
    position: relative;
}

.pth-hero-grid {
    display: grid;
    grid-template-columns: 1.18fr 0.82fr;
    gap: 48px;
    align-items: center;
}

/* Hero Left */
.pth-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--teal-badge-bg);
    border: 1px solid var(--teal-badge-border);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    color: var(--primary-teal);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.pth-badge-dot {
    width: 6px;
    height: 6px;
    background: var(--primary-teal);
    border-radius: 50%;
}

.pth-hero-title {
    font-size: clamp(34px, 4.4vw, 52px);
    font-weight: 900;
    color: var(--ink);
    line-height: 1.15;
    letter-spacing: -0.04em;
    margin-bottom: 16px;
}

.pth-hero-sub {
    font-size: 15.5px;
    color: var(--body-text);
    line-height: 1.65;
    max-width: 550px;
    margin-bottom: 26px;
}

/* Search Box */
.pth-search-container {
    position: relative;
    max-width: 580px;
    margin-bottom: 16px;
}

.pth-search-box {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #d1e9ec;
    border-radius: 12px;
    padding: 6px 6px 6px 18px;
    box-shadow: 0 10px 30px rgba(12, 105, 120, 0.08);
    transition: border-color 0.2s, box-shadow 0.2s;
}

.pth-search-box:focus-within {
    border-color: var(--primary-teal);
    box-shadow: 0 12px 34px rgba(12, 105, 120, 0.16);
}

.pth-search-icon {
    color: #94a3b8;
    font-size: 16px;
    margin-right: 12px;
    flex-shrink: 0;
}

.pth-search-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14.5px;
    font-family: inherit;
    color: var(--ink);
    font-weight: 500;
    background: transparent;
}

.pth-search-input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.pth-search-btn {
    background: var(--primary-teal);
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.18s;
    white-space: nowrap;
}

.pth-search-btn:hover {
    background: var(--primary-teal-dark);
}

/* Autocomplete Dropdown */
#hp-doctor-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.18);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    z-index: 99;
    display: none;
}
#hp-doctor-dropdown.open { display: block; }
#hp-doctor-dropdown a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--ink) !important;
}
#hp-doctor-dropdown a:hover {
    background: #f0fdfa;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   POPULAR CONDITIONS GRID CARDS (Direct Filter)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-popular-conditions {
    margin-top: 22px;
    max-width: 580px;
}

.pth-pop-cond-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.pth-pop-cond-title {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.01em;
}

.pth-pop-clear-btn {
    background: none;
    border: none;
    font-size: 12px;
    font-weight: 700;
    color: #ef4444;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 4px;
}
.pth-pop-clear-btn:hover {
    background: #fee2e2;
}

.pth-pop-cond-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
}

.pth-cond-card {
    background: #ffffff;
    border: 1.5px solid #d1e9ec;
    border-radius: 14px;
    padding: 12px 6px 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 88px;
    user-select: none;
    box-shadow: 0 2px 8px rgba(12, 105, 120, 0.04);
}

.pth-cond-card:hover {
    border-color: var(--primary-teal);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(12, 105, 120, 0.12);
    background: var(--teal-bg-soft);
}

.pth-cond-card.active {
    border-color: var(--primary-teal);
    background: #eef8f9;
    box-shadow: 0 4px 16px rgba(12, 105, 120, 0.22);
    outline: 2px solid rgba(12, 105, 120, 0.15);
}

.pth-cond-card.active .pth-cond-name {
    color: var(--primary-teal-dark);
    font-weight: 900;
}

.pth-cond-icon-svg {
    width: 38px;
    height: 38px;
    margin-bottom: 6px;
    color: var(--primary-teal);
    flex-shrink: 0;
}

.pth-cond-name {
    font-size: 12px;
    font-weight: 700;
    color: var(--primary-teal);
    line-height: 1.25;
}

/* Hero Right: Sleek App Mockup Frame */
.pth-mockup-wrapper {
    display: flex;
    justify-content: center;
    position: relative;
}

.pth-phone-mockup {
    width: 100%;
    max-width: 360px;
    background: #ffffff;
    border-radius: 36px;
    box-shadow: 0 24px 60px rgba(12, 105, 120, 0.15), 0 0 0 10px #f1f5f9, 0 0 0 12px #e2e8f0;
    overflow: hidden;
    position: relative;
    padding: 20px 18px;
    border: 1px solid #edf2f7;
}

.pth-mock-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
}
.pth-mock-notch {
    width: 60px;
    height: 4px;
    background: #cbd5e1;
    border-radius: 4px;
    margin: 0 auto;
}

.pth-mock-categories {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 14px;
    text-align: center;
}
.pth-mock-cat-item {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 10px;
    padding: 8px 4px;
}
.pth-mock-cat-icon {
    font-size: 16px;
    color: var(--primary-teal);
    margin-bottom: 4px;
}
.pth-mock-cat-text {
    font-size: 9.5px;
    font-weight: 700;
    color: #475569;
}

.pth-mock-card-primary {
    background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-teal-dark) 100%);
    border-radius: 16px;
    padding: 16px;
    color: #ffffff;
    margin-bottom: 16px;
    box-shadow: 0 8px 20px rgba(12, 105, 120, 0.25);
}
.pth-mock-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.pth-mock-card-title {
    font-size: 14px;
    font-weight: 800;
    letter-spacing: -0.02em;
}
.pth-mock-card-pill {
    background: rgba(255, 255, 255, 0.2);
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 50px;
}
.pth-mock-card-desc {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 12px;
    line-height: 1.4;
}

.pth-mock-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    text-align: center;
}
.pth-mock-stat-val {
    font-size: 13px;
    font-weight: 800;
}
.pth-mock-stat-lbl {
    font-size: 9px;
    color: rgba(255, 255, 255, 0.7);
}

.pth-mock-doc-box {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
}
.pth-mock-doc-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.pth-mock-doc-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #38bdf8, var(--primary-teal));
    color: #ffffff;
    font-weight: 800;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pth-mock-doc-name {
    font-size: 13px;
    font-weight: 800;
    color: var(--ink);
}
.pth-mock-doc-badge {
    font-size: 10px;
    font-weight: 700;
    color: #d97706;
    background: #fef3c7;
    padding: 1px 6px;
    border-radius: 4px;
    margin-left: 4px;
}
.pth-mock-doc-sub {
    font-size: 10.5px;
    color: #64748b;
}

.pth-mock-doc-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 8px;
    border-top: 1px dashed #e2e8f0;
    margin-top: 8px;
}
.pth-mock-doc-status {
    font-size: 11px;
    color: var(--accent-green);
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 4px;
}
.pth-mock-doc-price {
    font-size: 13px;
    font-weight: 800;
    color: var(--primary-teal);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   VALUE / TREATMENT BANNER (Dark Teal Box)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-value-banner-wrap {
    padding: 10px 0 60px;
}

.pth-value-banner {
    background: var(--primary-teal);
    border-radius: var(--radius-xl);
    padding: 40px 48px 36px;
    color: #ffffff;
    box-shadow: 0 16px 40px rgba(12, 105, 120, 0.22);
    position: relative;
    overflow: hidden;
}

.pth-banner-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding-bottom: 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.18);
    flex-wrap: wrap;
}

.pth-banner-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.pth-banner-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #ffffff;
    flex-shrink: 0;
}

.pth-banner-title {
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -0.03em;
    color: #ffffff;
}

.pth-banner-desc {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    margin-top: 2px;
}

.pth-btn-white {
    background: #ffffff;
    color: var(--primary-teal) !important;
    padding: 12px 28px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
}

.pth-btn-white:hover {
    background: #f0fdfa;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
}

.pth-banner-features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 36px;
    padding-top: 30px;
}

.pth-feat-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.pth-feat-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
    border: 1.5px solid rgba(255, 255, 255, 0.28);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: #ffffff;
    flex-shrink: 0;
    margin-top: 2px;
}

.pth-feat-title {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 4px;
}

.pth-feat-desc {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.55;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   AVAILABLE NEARBY PHYSIOS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-doctors-section {
    padding: 40px 0 80px;
}

.pth-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.pth-sec-title {
    font-size: 28px;
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.03em;
}

.pth-sec-sub {
    font-size: 14.5px;
    color: var(--muted-text);
    margin-top: 4px;
}

.pth-see-all-link {
    font-size: 14px;
    font-weight: 700;
    color: var(--primary-teal);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}
.pth-see-all-link:hover {
    color: var(--primary-teal-dark);
    gap: 9px;
}

/* Filter active status banner */
#pth-filter-banner {
    display: none;
    align-items: center;
    justify-content: space-between;
    background: #eef8f9;
    border: 1.5px solid #bce5ea;
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 24px;
}
.pth-filter-banner-text {
    font-size: 14px;
    color: #074752;
    font-weight: 700;
}
.pth-filter-banner-text strong {
    color: var(--primary-teal);
    font-weight: 800;
}
.pth-filter-badge-btn {
    background: #ffffff;
    border: 1px solid #bce5ea;
    color: #0c6978;
    border-radius: 6px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
}
.pth-filter-badge-btn:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #b91c1c;
}

.pth-doctors-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.pth-doctor-card {
    background: #ffffff;
    border: 1.5px solid #edf2f7;
    border-radius: 18px;
    padding: 24px;
    box-shadow: var(--shadow-card);
    transition: all 0.22s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.pth-doctor-card:hover {
    border-color: #bce5ea;
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
}

.pth-doc-header {
    display: flex;
    gap: 16px;
    margin-bottom: 18px;
}

.pth-doc-avatar {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    flex-shrink: 0;
}

.pth-doc-avatar-ph {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--teal-badge-bg), #bce5ea);
    color: var(--primary-teal);
    font-size: 22px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 2px solid #e2e8f0;
}

.pth-doc-details {
    flex: 1;
    min-width: 0;
}

.pth-doc-name-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 4px;
}

.pth-doc-name {
    font-size: 16.5px;
    font-weight: 800;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pth-badge-verified {
    background: #fef3c7;
    color: #b45309;
    font-size: 10.5px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 4px;
    white-space: nowrap;
}

.pth-doc-spec {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--primary-teal);
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pth-doc-stats-mini {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #64748b;
}

.pth-doc-rating {
    color: #b45309;
    font-weight: 700;
}

.pth-doc-card-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
    margin-top: auto;
    gap: 12px;
}

.pth-status-tag {
    font-size: 12px;
    font-weight: 700;
    color: #059669;
    display: flex;
    align-items: center;
    gap: 6px;
}
.pth-status-tag::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10b981;
}

.pth-btn-book-sm {
    background: var(--primary-teal);
    color: #ffffff !important;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    transition: all 0.18s;
    white-space: nowrap;
}

.pth-btn-book-sm:hover {
    background: var(--primary-teal-dark);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   WHY CHOOSE US
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-why-section {
    padding: 70px 0;
    background: #f8fafc;
}

.pth-center-head {
    text-align: center;
    max-width: 640px;
    margin: 0 auto 48px;
}

.pth-center-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--teal-badge-bg);
    border: 1px solid var(--teal-badge-border);
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    color: var(--primary-teal);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 14px;
}

.pth-center-title {
    font-size: clamp(26px, 3.5vw, 36px);
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.03em;
    margin-bottom: 12px;
}

.pth-center-sub {
    font-size: 15px;
    color: var(--muted-text);
    line-height: 1.65;
}

.pth-why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.pth-why-card {
    background: #ffffff;
    border: 1.5px solid #edf2f7;
    border-radius: 16px;
    padding: 28px 24px;
    transition: all 0.2s;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
}

.pth-why-card:hover {
    border-color: #bce5ea;
    transform: translateY(-3px);
    box-shadow: var(--shadow-soft);
}

.pth-why-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: var(--teal-bg-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-teal);
    font-size: 20px;
    margin-bottom: 16px;
}

.pth-why-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 8px;
}

.pth-why-desc {
    font-size: 13.5px;
    color: var(--body-text);
    line-height: 1.6;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HOW IT WORKS (5 Steps)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-how-section {
    padding: 80px 0;
    background: #ffffff;
}

.pth-steps-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

.pth-step-card {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 16px;
    padding: 24px 20px;
    position: relative;
    transition: all 0.2s;
}

.pth-step-card:hover {
    border-color: var(--teal-badge-border);
    transform: translateY(-3px);
    box-shadow: var(--shadow-soft);
}

.pth-step-num {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--teal-bg-soft);
    color: var(--primary-teal);
    border: 1.5px solid var(--teal-badge-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 900;
    margin-bottom: 18px;
}

.pth-step-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 8px;
    line-height: 1.35;
}

.pth-step-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.55;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   SUPPORT & FAQ BANNER (Dark Teal Box)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-support-section {
    padding: 20px 0 80px;
}

.pth-support-banner {
    background: var(--primary-teal);
    border-radius: var(--radius-xl);
    padding: 48px;
    color: #ffffff;
    box-shadow: 0 20px 50px rgba(12, 105, 120, 0.25);
}

.pth-support-grid {
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: 48px;
    align-items: center;
}

.pth-support-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 18px;
    color: #ffffff;
}

.pth-support-title {
    font-size: clamp(28px, 3.2vw, 38px);
    font-weight: 900;
    color: #ffffff;
    letter-spacing: -0.03em;
    margin-bottom: 14px;
}

.pth-support-desc {
    font-size: 14.5px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.65;
    margin-bottom: 28px;
}

.pth-support-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.pth-btn-call {
    background: #ffffff;
    color: var(--primary-teal) !important;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}
.pth-btn-call:hover {
    background: #f0fdfa;
    transform: translateY(-2px);
}

.pth-btn-chat {
    background: rgba(255, 255, 255, 0.12);
    border: 1.5px solid rgba(255, 255, 255, 0.35);
    color: #ffffff !important;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.pth-btn-chat:hover {
    background: rgba(255, 255, 255, 0.22);
}

/* FAQ Box */
.pth-faq-box {
    background: rgba(0, 0, 0, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 20px;
    padding: 28px;
}

.pth-faq-title {
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 18px;
}

.pth-faq-item {
    padding-bottom: 14px;
    margin-bottom: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
}
.pth-faq-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.pth-faq-q {
    font-size: 13.5px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 4px;
}

.pth-faq-a {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.55;
}

.pth-btn-support-email {
    margin-top: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 8px;
    padding: 10px;
    font-size: 12.5px;
    font-weight: 700;
    color: #ffffff !important;
    transition: all 0.18s;
}
.pth-btn-support-email:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   FOOTER (Dark Navy)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pth-footer {
    background: var(--footer-bg);
    color: #94a3b8;
    padding: 64px 0 28px;
}

.pth-footer-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr 1.1fr;
    gap: 40px;
    margin-bottom: 48px;
}

.pth-footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    text-decoration: none;
}
.pth-footer-brand-name {
    font-size: 20px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: -0.03em;
}
.pth-footer-brand-name span {
    color: var(--accent-mint);
}

.pth-footer-about {
    font-size: 13.5px;
    line-height: 1.7;
    color: #94a3b8;
    max-width: 320px;
}

.pth-footer-heading {
    font-size: 13px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.pth-footer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.pth-footer-links a {
    font-size: 13.5px;
    color: #94a3b8;
    transition: color 0.18s;
}

.pth-footer-links a:hover {
    color: #ffffff;
}

.pth-footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    font-size: 12.5px;
    flex-wrap: wrap;
    gap: 12px;
}

.pth-social-row {
    display: flex;
    align-items: center;
    gap: 16px;
}

.pth-social-link {
    color: #94a3b8;
    font-size: 15px;
    transition: color 0.18s;
}

.pth-social-link:hover {
    color: #ffffff;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   RESPONSIVE DESIGN
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
@media (max-width: 1024px) {
    .pth-hero-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .pth-mockup-wrapper {
        order: -1;
    }
    .pth-phone-mockup {
        max-width: 380px;
    }
    .pth-banner-features {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .pth-doctors-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .pth-why-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .pth-steps-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .pth-support-grid {
        grid-template-columns: 1fr;
    }
    .pth-footer-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .pth-nav-links, .pth-call-pill {
        display: none;
    }
    .pth-menu-toggle {
        display: block;
    }
    .pth-value-banner {
        padding: 30px 24px;
    }
    .pth-doctors-grid {
        grid-template-columns: 1fr;
    }
    .pth-why-grid {
        grid-template-columns: 1fr;
    }
    .pth-steps-grid {
        grid-template-columns: 1fr;
    }
    .pth-support-banner {
        padding: 32px 24px;
    }
    .pth-footer-grid {
        grid-template-columns: 1fr;
    }
    .pth-pop-cond-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 440px) {
    .pth-pop-cond-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* ─────────────────────────────────────────────
   ENQUIRY MODAL STYLES
───────────────────────────────────────────── */
.pth-enquiry-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    backdrop-filter: blur(4px);
    opacity: 1;
    visibility: visible;
    transition: all .2s ease;
}
.pth-enquiry-overlay.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
.pth-enquiry-modal {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 520px;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    position: relative;
    animation: pthModalPop .22s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes pthModalPop {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.pth-enquiry-header {
    background: linear-gradient(135deg, #074752 0%, #0c6978 100%);
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #ffffff;
}
.pth-enquiry-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pth-enquiry-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #ffffff;
    flex-shrink: 0;
}
.pth-enquiry-title {
    font-size: 17.5px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.25;
    margin: 0;
}
.pth-enquiry-sub {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.82);
    margin-top: 3px;
    margin-bottom: 0;
}
.pth-enquiry-close {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: #ffffff;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s;
    line-height: 1;
}
.pth-enquiry-close:hover {
    background: rgba(255, 255, 255, 0.3);
}
.pth-enquiry-body {
    padding: 22px 24px 16px;
    overflow-y: auto;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.pth-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.pth-form-label {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
}
.pth-form-label .req {
    color: #ef4444;
}
.pth-form-label .opt {
    color: #94a3b8;
    font-weight: 500;
    font-size: 11.5px;
}
.pth-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.pth-input-icon {
    position: absolute;
    left: 14px;
    color: #94a3b8;
    font-size: 14px;
    pointer-events: none;
}
.pth-form-input, .pth-form-select, .pth-form-textarea {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 11px;
    font-size: 14px;
    font-family: inherit;
    color: #0f172a;
    background: #f8fafc;
    transition: all .18s ease;
    outline: none;
}
.pth-form-input {
    height: 44px;
    padding: 0 14px 0 38px;
}
.pth-form-select {
    height: 44px;
    padding: 0 14px 0 38px;
    cursor: pointer;
}
.pth-form-textarea {
    padding: 10px 14px;
    resize: vertical;
    min-height: 65px;
}
.pth-form-input:focus, .pth-form-select:focus, .pth-form-textarea:focus {
    border-color: #0c6978;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(12, 105, 120, 0.12);
}
.pth-enquiry-trust-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    border-radius: 10px;
    padding: 10px 12px;
    margin-top: 4px;
}
.pth-trust-item {
    font-size: 11.5px;
    font-weight: 700;
    color: #0f766e;
    display: flex;
    align-items: center;
    gap: 5px;
    justify-content: center;
    text-align: center;
}
.pth-enquiry-footer {
    padding: 14px 24px 20px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    background: #ffffff;
}
.pth-btn-ghost {
    padding: 11px 20px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all .15s;
}
.pth-btn-ghost:hover {
    background: #f8fafc;
    color: #0f172a;
}
.pth-btn-teal {
    padding: 11px 24px;
    border-radius: 10px;
    background: #0c6978;
    border: 1.5px solid #0c6978;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all .15s;
    box-shadow: 0 4px 12px rgba(12, 105, 120, 0.25);
    text-decoration: none;
}
.pth-btn-teal:hover {
    background: #074752;
    border-color: #074752;
    color: #ffffff;
}
.pth-enquiry-success {
    padding: 40px 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.pth-enquiry-success-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #dcfce7;
    color: #16a34a;
    font-size: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
}
.pth-enquiry-success h4 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.pth-enquiry-success p {
    font-size: 14px;
    color: #64748b;
    max-width: 360px;
    line-height: 1.5;
    margin: 0;
}
.pth-enquiry-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 14px;
    border-radius: 10px;
}
</style>

<div class="main-wrapper">

    {{-- ══════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════ --}}
    <nav class="pth-navbar">
        <div class="home-container">
            <div class="pth-nav-inner">
                <a href="{{ route('home') }}" class="pth-brand">
                    <img src="{{ asset('logo.png') }}" alt="PhysioPii" style="height:44px;width:auto;object-fit:contain;display:block;">
                </a>

                <ul class="pth-nav-links">
                    <li><a href="{{ route('home') }}" class="pth-nav-link active">Home</a></li>
                    <li><a href="#specialists" class="pth-nav-link">Our Specialists</a></li>
                    <li><a href="#conditions" class="pth-nav-link">Conditions Treated</a></li>
                    <li><a href="#how-it-works" class="pth-nav-link">How It Works</a></li>
                    <li><a href="#pricing" class="pth-nav-link">Pricing</a></li>
                </ul>

                <div class="pth-nav-right">
                    <a href="tel:+919513211470" class="pth-call-pill">
                        <i class="fa-solid fa-phone"></i>
                        <span>Call Us:</span> (555) 492-1008
                    </a>

                    @auth
                        <a href="{{ route('patient.dashboard') }}" class="pth-btn-book">
                            <i class="fa-solid fa-user"></i> Dashboard
                        </a>
                    @else
                        <a href="#specialists" class="pth-btn-book">
                            Book  Session
                        </a>
                    @endauth

                    <button class="pth-menu-toggle" id="mobileMenuBtn" aria-label="Toggle menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════════════════ --}}
    <section class="pth-hero-section">
        <div class="home-container">
            <div class="pth-hero-grid">

                {{-- Left Content --}}
                <div class="pth-hero-left">
                    <div class="pth-hero-badge">
                        <span class="pth-badge-dot"></span>
                        EXPERT CARE IN YOUR COMFORT ZONE
                    </div>

                    <h1 class="pth-hero-title">
                        Professional Physiotherapy,<br>
                        Right in Your Living Room
                    </h1>

                    <p class="pth-hero-sub">
                        Skip the stressful commute and clinical waiting rooms. Receive certified, trusted home-visit physiotherapists specialized in pain recovery, injury rehabilitation, and personalized mobility care.
                    </p>

                    {{-- Search condition bar --}}
                    <div class="pth-search-container" id="conditions">
                        <div class="pth-search-box">
                            <i class="fa-solid fa-magnifying-glass pth-search-icon"></i>
                            <input
                                type="text"
                                id="doctorSearch"
                                class="pth-search-input"
                                placeholder="Search your condition (e.g. Back pain, Stroke rehab, Knee injury)..."
                                autocomplete="off"
                            >
                            <button type="button" class="pth-search-btn" id="searchSubmitBtn">
                                Find Doctors
                            </button>
                        </div>
                        <div id="hp-doctor-dropdown"></div>
                    </div>

                    {{-- ── Popular Conditions Grid Cards (Click & Filter Directly) ── --}}
                    <div class="pth-popular-conditions">
                        <div class="pth-pop-cond-header">
                            <span class="pth-pop-cond-title">Popular Conditions</span>
                            <button type="button" class="pth-pop-clear-btn" id="clearPopCondBtn" style="display:none;" onclick="clearConditionFilter()">
                                <i class="fa-solid fa-xmark"></i> Clear Filter
                            </button>
                        </div>

                        <div class="pth-pop-cond-grid">
                            {{-- Back Pain --}}
                            <div class="pth-cond-card" data-condition="Back Pain" onclick="toggleConditionFilter('Back Pain', this)">
                                <svg class="pth-cond-icon-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 10 C16 6, 32 6, 32 10 C32 14, 28 16, 28 20 C28 26, 34 32, 34 40 L14 40 C14 32, 20 26, 20 20 C20 16, 16 14, 16 10 Z" stroke="#0c6978" fill="#f0fdfa"/>
                                    <circle cx="24" cy="14" r="1.5" fill="#0c6978"/>
                                    <circle cx="24" cy="20" r="1.8" fill="#0c6978"/>
                                    <circle cx="24" cy="26" r="2.2" fill="#ef4444"/>
                                    <circle cx="24" cy="32" r="2.2" fill="#ef4444"/>
                                    <path d="M19 28 L17 29 M29 28 L31 29 M19 31 L17 32 M29 31 L31 32" stroke="#ef4444" stroke-width="2"/>
                                </svg>
                                <span class="pth-cond-name">Back Pain</span>
                            </div>

                            {{-- Neck Pain --}}
                            <div class="pth-cond-card" data-condition="Neck Pain" onclick="toggleConditionFilter('Neck Pain', this)">
                                <svg class="pth-cond-icon-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="24" cy="14" r="7" stroke="#0c6978" fill="#f0fdfa"/>
                                    <path d="M21 21 L21 27 C16 28, 12 32, 10 38 L38 38 C36 32, 32 28, 27 27 L27 21" stroke="#0c6978"/>
                                    <path d="M17 23 L14 22 M17 26 L14 27 M31 23 L34 22 M31 26 L34 27" stroke="#ef4444" stroke-width="2"/>
                                    <circle cx="24" cy="25" r="2" fill="#ef4444"/>
                                </svg>
                                <span class="pth-cond-name">Neck Pain</span>
                            </div>

                            {{-- Knee Pain --}}
                            <div class="pth-cond-card" data-condition="Knee Pain" onclick="toggleConditionFilter('Knee Pain', this)">
                                <svg class="pth-cond-icon-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 10 L28 22 L20 38" stroke="#0c6978" stroke-width="3" fill="none"/>
                                    <circle cx="28" cy="22" r="4" fill="#fef2f2" stroke="#ef4444" stroke-width="2"/>
                                    <path d="M34 18 L37 16 M35 22 L39 22 M34 26 L37 28" stroke="#ef4444" stroke-width="2"/>
                                </svg>
                                <span class="pth-cond-name">Knee Pain</span>
                            </div>

                            {{-- Shoulder Pain --}}
                            <div class="pth-cond-card" data-condition="Shoulder Pain" onclick="toggleConditionFilter('Shoulder Pain', this)">
                                <svg class="pth-cond-icon-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="20" cy="14" r="6" stroke="#0c6978" fill="#f0fdfa"/>
                                    <path d="M17 20 C12 24, 12 34, 12 40 L28 40" stroke="#0c6978"/>
                                    <path d="M24 20 C32 20, 36 26, 34 34 L26 28" stroke="#0c6978"/>
                                    <circle cx="30" cy="23" r="3" fill="#fef2f2" stroke="#ef4444" stroke-width="2"/>
                                    <path d="M35 18 L38 16 M36 24 L40 24" stroke="#ef4444" stroke-width="2"/>
                                </svg>
                                <span class="pth-cond-name">Shoulder Pain</span>
                            </div>

                            {{-- Hip Pain --}}
                            <div class="pth-cond-card" data-condition="Hip Pain" onclick="toggleConditionFilter('Hip Pain', this)">
                                <svg class="pth-cond-icon-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="24" cy="11" r="5" stroke="#0c6978" fill="#f0fdfa"/>
                                    <path d="M24 16 L24 27 M24 27 L18 39 M24 27 L30 39" stroke="#0c6978" stroke-width="2.5"/>
                                    <circle cx="27" cy="27" r="3.5" fill="#fef2f2" stroke="#ef4444" stroke-width="2"/>
                                    <path d="M32 24 L35 23 M33 29 L36 31" stroke="#ef4444" stroke-width="2"/>
                                </svg>
                                <span class="pth-cond-name">Hip Pain</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Visual: Sleek Interactive App Mockup --}}
                <div class="pth-mockup-wrapper">
                    <div class="pth-phone-mockup">
                        <div class="pth-mock-header">
                            <span style="font-size:11px;font-weight:700;color:#0c6978;">Physiopii Mobile</span>
                            <div class="pth-mock-notch"></div>
                            <i class="fa-solid fa-wifi" style="font-size:10px;color:#94a3b8;"></i>
                        </div>

                        <div class="pth-mock-categories">
                            <div class="pth-mock-cat-item" style="cursor:pointer" onclick="toggleConditionFilter('Back Pain')">
                                <div class="pth-mock-cat-icon"><i class="fa-solid fa-bone"></i></div>
                                <div class="pth-mock-cat-text">Spine</div>
                            </div>
                            <div class="pth-mock-cat-item" style="cursor:pointer" onclick="toggleConditionFilter('Knee Pain')">
                                <div class="pth-mock-cat-icon"><i class="fa-solid fa-person-walking"></i></div>
                                <div class="pth-mock-cat-text">Knee</div>
                            </div>
                            <div class="pth-mock-cat-item" style="cursor:pointer" onclick="toggleConditionFilter('Shoulder Pain')">
                                <div class="pth-mock-cat-icon"><i class="fa-solid fa-hand-dots"></i></div>
                                <div class="pth-mock-cat-text">Joints</div>
                            </div>
                            <div class="pth-mock-cat-item" style="cursor:pointer" onclick="toggleConditionFilter('Neck Pain')">
                                <div class="pth-mock-cat-icon"><i class="fa-solid fa-brain"></i></div>
                                <div class="pth-mock-cat-text">Neuro</div>
                            </div>
                        </div>

                        {{-- Mock Primary Card --}}
                        <div class="pth-mock-card-primary">
                            <div class="pth-mock-card-top">
                                <div class="pth-mock-card-title"><i class="fa-solid fa-house-medical"></i> Book a Session</div>
                                <span class="pth-mock-card-pill">Active</span>
                            </div>
                            <div class="pth-mock-card-desc">
                                Quality home care delivered with verified therapist background checks.
                            </div>
                            <div class="pth-mock-stats-row">
                                <div>
                                    <div class="pth-mock-stat-val">100+</div>
                                    <div class="pth-mock-stat-lbl">Physios</div>
                                </div>
                                <div>
                                    <div class="pth-mock-stat-val">4.9★</div>
                                    <div class="pth-mock-stat-lbl">Rating</div>
                                </div>
                                <div>
                                    <div class="pth-mock-stat-val">10k+</div>
                                    <div class="pth-mock-stat-lbl">Sessions</div>
                                </div>
                            </div>
                        </div>

                        {{-- Mock Doctor Preview Box --}}
                        <div class="pth-mock-doc-box">
                            <div class="pth-mock-doc-header">
                                <div class="pth-mock-doc-avatar">DJ</div>
                                <div>
                                    <div class="pth-mock-doc-name">
                                        Dr. John
                                        <span class="pth-mock-doc-badge">★ Verified</span>
                                    </div>
                                    <div class="pth-mock-doc-sub">MPT (Neuro Rehab) &middot; 10 Years Exp.</div>
                                    <div style="font-size:10px;color:#d97706;margin-top:2px;">★ 4.9 (152 Reviews)</div>
                                </div>
                            </div>
                            <div class="pth-mock-doc-footer">
                                <span class="pth-mock-doc-status">
                                    <i class="fa-solid fa-circle" style="font-size:6px;"></i> Available Today
                                </span>
                                <span class="pth-mock-doc-price">₹1,100 / session</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         VALUE / TREATMENT BANNER (Dark Teal Box)
    ══════════════════════════════════════════════════ --}}
    <section class="pth-value-banner-wrap" id="pricing">
        <div class="home-container">
            <div class="pth-value-banner">

                <div class="pth-banner-top">
                    <div class="pth-banner-left">
                        <div class="pth-banner-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="pth-banner-title">Book a Treatment Session</div>
                            <div class="pth-banner-desc">Quality healthcare delivered directly in the safety and comfort of your home.</div>
                        </div>
                    </div>
                    <button type="button" class="pth-btn-white" onclick="openEnquiryModal()" style="border:none;cursor:pointer;">
                        Book Home Visit <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

                <div class="pth-banner-features">
                    <div class="pth-feat-item">
                        <div class="pth-feat-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="pth-feat-title">Verified Experts</div>
                            <div class="pth-feat-desc">Receive certified, vetted and background-checked physios.</div>
                        </div>
                    </div>

                    <div class="pth-feat-item">
                        <div class="pth-feat-icon">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div>
                            <div class="pth-feat-title">Affordable Care</div>
                            <div class="pth-feat-desc">Transparent session packages with no hidden consultation fees.</div>
                        </div>
                    </div>

                    <div class="pth-feat-item">
                        <div class="pth-feat-icon">
                            <i class="fa-solid fa-house-chimney-user"></i>
                        </div>
                        <div>
                            <div class="pth-feat-title">At Your Home</div>
                            <div class="pth-feat-desc">Convenient treatment in the familiar, stress-free comfort of your living space.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         AVAILABLE NEARBY PHYSIOS
    ══════════════════════════════════════════════════ --}}
    <section class="pth-doctors-section" id="specialists">
        <div class="home-container">

            <div class="pth-section-header">
                <div>
                    <h2 class="pth-sec-title">Available Nearby Physios</h2>
                    <p class="pth-sec-sub">Certified, home-visit physiotherapists active in your immediate locality</p>
                </div>
                <a href="javascript:void(0)" onclick="clearConditionFilter()" class="pth-see-all-link">
                    See All Specialists <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>

            {{-- Filter Status Alert Bar --}}
            <div id="pth-filter-banner">
                <div class="pth-filter-banner-text">
                    <i class="fa-solid fa-filter" style="margin-right:6px;color:var(--primary-teal);"></i>
                    Filtered by: <strong id="pth-active-filter-text">Back Pain</strong>
                    <span id="pth-filter-count" style="font-size:12.5px;color:#64748b;margin-left:8px;"></span>
                </div>
                <button type="button" class="pth-filter-badge-btn" onclick="clearConditionFilter()">
                    <i class="fa-solid fa-xmark"></i> Clear Filter
                </button>
            </div>

            {{-- Doctors Grid --}}
            <div class="pth-doctors-grid" id="pthDoctorsGrid">
                @forelse($doctors as $doctor)
                    @php
                        $rating = round(optional($doctor->profile)->rating ?? 4.9, 1);
                        if ($rating < 4.5) $rating = 4.9;
                        $expYears = optional($doctor->profile)->experience_years ?? 8;
                        $qualification = optional($doctor->profile)->qualification ?? 'MPT';
                        $specName = optional(optional($doctor->profile)->specializationdata)->name ?? 'Pain & Mobility Rehab';
                        $hasImg = !empty($doctor->profile_img);
                        $reviewsCount = rand(90, 210);

                        $searchKeywords = strtolower($doctor->name . ' ' . $qualification . ' ' . $specName . ' ' . ($doctor->address ?? ''));
                    @endphp
                    <div class="pth-doctor-card"
                         data-name="{{ strtolower($doctor->name) }}"
                         data-spec="{{ strtolower($specName) }}"
                         data-qual="{{ strtolower($qualification) }}"
                         data-keywords="{{ $searchKeywords }}">
                        <div>
                            <a href="{{ route('doctor.profile', $doctor->id) }}" class="pth-doc-header" style="text-decoration:none;color:inherit;">
                                @if($hasImg)
                                    <img
                                        src="{{ str_contains($doctor->profile_img, '/') ? asset($doctor->profile_img) : asset('uploads/profile/'.$doctor->profile_img) }}"
                                        alt="{{ $doctor->name }}"
                                        class="pth-doc-avatar"
                                    >
                                @else
                                    <div class="pth-doc-avatar-ph">
                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="pth-doc-details">
                                    <div class="pth-doc-name-row">
                                        <div class="pth-doc-name">Dr. {{ $doctor->name }}</div>
                                        <span class="pth-badge-verified">★ Verified</span>
                                    </div>
                                    <div class="pth-doc-spec">{{ $qualification }} ({{ $specName }})</div>
                                    <div class="pth-doc-stats-mini">
                                        <span class="pth-doc-rating">★ {{ $rating }} ({{ $reviewsCount }} Reviews)</span>
                                        <span>&middot; {{ $expYears }} Years Exp.</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="pth-doc-card-bottom">
                            <span class="pth-status-tag">Available Today</span>
                            <a href="{{ route('doctor.profile', $doctor->id) }}" class="pth-btn-book-sm">
                                Book  Session
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Default fallback doctor cards if empty database --}}
                    <div class="pth-doctor-card" data-keywords="back spine neuro ortho john">
                        <div>
                            <div class="pth-doc-header">
                                <div class="pth-doc-avatar-ph">J</div>
                                <div class="pth-doc-details">
                                    <div class="pth-doc-name-row">
                                        <div class="pth-doc-name">Dr. John</div>
                                        <span class="pth-badge-verified">★ Verified</span>
                                    </div>
                                    <div class="pth-doc-spec">MPT (Neuro &amp; Spine Rehab)</div>
                                    <div class="pth-doc-stats-mini">
                                        <span class="pth-doc-rating">★ 4.9 (152 Reviews)</span>
                                        <span>&middot; 10 Years Exp.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pth-doc-card-bottom">
                            <span class="pth-status-tag">Available Today</span>
                            <a href="{{ route('login') }}" class="pth-btn-book-sm">Book Home Session</a>
                        </div>
                    </div>

                    <div class="pth-doctor-card" data-keywords="knee joint ortho arthritis millward">
                        <div>
                            <div class="pth-doc-header">
                                <div class="pth-doc-avatar-ph">K</div>
                                <div class="pth-doc-details">
                                    <div class="pth-doc-name-row">
                                        <div class="pth-doc-name">Dr. Karen Millward</div>
                                        <span class="pth-badge-verified">★ Verified</span>
                                    </div>
                                    <div class="pth-doc-spec">MPT (Orthopaedic &amp; Knee Care)</div>
                                    <div class="pth-doc-stats-mini">
                                        <span class="pth-doc-rating">★ 4.9 (142 Reviews)</span>
                                        <span>&middot; 8 Years Exp.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pth-doc-card-bottom">
                            <span class="pth-status-tag">Available Today</span>
                            <a href="{{ route('login') }}" class="pth-btn-book-sm">Book Home Session</a>
                        </div>
                    </div>

                    <div class="pth-doctor-card" data-keywords="shoulder neck sports patel">
                        <div>
                            <div class="pth-doc-header">
                                <div class="pth-doc-avatar-ph">A</div>
                                <div class="pth-doc-details">
                                    <div class="pth-doc-name-row">
                                        <div class="pth-doc-name">Dr. Avis Patel</div>
                                        <span class="pth-badge-verified">★ Verified</span>
                                    </div>
                                    <div class="pth-doc-spec">MPT (Sports &amp; Shoulder Rehabilitation)</div>
                                    <div class="pth-doc-stats-mini">
                                        <span class="pth-doc-rating">★ 4.9 (196 Reviews)</span>
                                        <span>&middot; 12 Years Exp.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pth-doc-card-bottom">
                            <span class="pth-status-tag">Available Today</span>
                            <a href="{{ route('login') }}" class="pth-btn-book-sm">Book Home Session</a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Zero results message --}}
            <div id="pthNoDoctors" style="display:none;text-align:center;padding:48px 24px;background:#f8fafc;border:1.5px dashed #cbd5e1;border-radius:18px;margin-top:20px;">
                <div style="font-size:36px;color:#0c6978;margin-bottom:10px;"><i class="fa-solid fa-user-doctor"></i></div>
                <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:6px;">No specific specialists found for this category</h3>
                <p style="font-size:14px;color:#64748b;margin-bottom:18px;">All our licensed home physiotherapists are certified across multiple rehabilitation categories.</p>
                <button type="button" class="pth-btn-book" onclick="clearConditionFilter()" style="margin:0 auto;">
                    View All Available Physios
                </button>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         WHY CHOOSE US
    ══════════════════════════════════════════════════ --}}
    <section class="pth-why-section">
        <div class="home-container">

            <div class="pth-center-head">
                <div class="pth-center-badge">
                    WHY CHOOSE US
                </div>
                <h2 class="pth-center-title">Why Choose PhysioAtHome</h2>
                <p class="pth-center-sub">
                    We combine clinical expertise with the comfort of your home for a truly personalized recovery experience.
                </p>
            </div>

            <div class="pth-why-grid">
                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <div class="pth-why-title">Verified &amp; Experienced Physiotherapists</div>
                    <div class="pth-why-desc">
                        All our therapists undergo rigorous background checks, qualification vetting, and carry proven clinical track records.
                    </div>
                </div>

                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div class="pth-why-title">Personalized Treatment</div>
                    <div class="pth-why-desc">
                        Every session is crafted around your unique condition, lifestyle, and recovery goals — no generic exercises.
                    </div>
                </div>

                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-solid fa-house-user"></i>
                    </div>
                    <div class="pth-why-title">Home Visit Convenience</div>
                    <div class="pth-why-desc">
                        No more stressful clinic commutes. Your therapist comes equipped directly to your doorstep at your chosen time.
                    </div>
                </div>

                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="pth-why-title">Track Progress Digitally</div>
                    <div class="pth-why-desc">
                        Monitor your recovery milestones, session notes, and therapist feedback through our intuitive mobile/web app.
                    </div>
                </div>

                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-solid fa-hands-holding-child"></i>
                    </div>
                    <div class="pth-why-title">Safe, Hygienic &amp; Comfortable</div>
                    <div class="pth-why-desc">
                        Our therapists follow strict hygiene protocols and assist your family in rehabilitation exercises safely.
                    </div>
                </div>

                <div class="pth-why-card">
                    <div class="pth-why-icon-wrap">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="pth-why-title">Flexible Scheduling</div>
                    <div class="pth-why-desc">
                        Early morning, afternoon, or evening slots fit with ease in your routine — including weekend appointments.
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         HOW TO BOOK YOUR HOME SESSION (5 Steps)
    ══════════════════════════════════════════════════ --}}
    <section class="pth-how-section" id="how-it-works">
        <div class="home-container">

            <div class="pth-center-head">
                <div class="pth-center-badge">
                    SIMPLE RECOVERY PROCESS
                </div>
                <h2 class="pth-center-title">How to Book Your Home Session</h2>
            </div>

            <div class="pth-steps-grid">
                <div class="pth-step-card">
                    <div class="pth-step-num">1</div>
                    <div class="pth-step-title">Select Condition &amp; Address</div>
                    <div class="pth-step-desc">
                        Identify your primary symptoms or need and pin your location to view nearby available specialists.
                    </div>
                </div>

                <div class="pth-step-card">
                    <div class="pth-step-num">2</div>
                    <div class="pth-step-title">Choose Doctor &amp; Slot</div>
                    <div class="pth-step-desc">
                        Review verified specialist profiles, read real patient ratings, and pick a slot that fits your schedule.
                    </div>
                </div>

                <div class="pth-step-card">
                    <div class="pth-step-num">3</div>
                    <div class="pth-step-title">Comfortable At-Home Treatment</div>
                    <div class="pth-step-desc">
                        Your assigned physiotherapist arrives fully equipped for evaluation, exercise guidance, and therapy.
                    </div>
                </div>

                <div class="pth-step-card">
                    <div class="pth-step-num">4</div>
                    <div class="pth-step-title">Receive Your Recovery Plan</div>
                    <div class="pth-step-desc">
                        After each session, receive customized digital notes, exercise videos, and target milestones.
                    </div>
                </div>

                <div class="pth-step-card">
                    <div class="pth-step-num">5</div>
                    <div class="pth-step-title">Track &amp; Follow Up</div>
                    <div class="pth-step-desc">
                        Measure improvements in session logs, book follow-ups effortlessly, and stay connected with your therapist.
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         NEED HELP BOOKING? & FAQ (Dark Teal Box)
    ══════════════════════════════════════════════════ --}}
    <section class="pth-support-section">
        <div class="home-container">
            <div class="pth-support-banner">

                <div class="pth-support-grid">
                    <div>
                        <div class="pth-support-badge">
                            <i class="fa-solid fa-headset"></i> 24/7 Support Available
                        </div>
                        <h2 class="pth-support-title">Need Help Booking?</h2>
                        <p class="pth-support-desc">
                            Our dedicated care coordination team is ready to assist you every step of the way. Find the right specialist, navigate your options, and schedule your first home session with ease.
                        </p>

                        <div class="pth-support-actions">
                            <a href="tel:+919513211470" class="pth-btn-call">
                                <i class="fa-solid fa-phone"></i> Call (555) 492-1008
                            </a>
                            <a href="https://wa.me/919513211470" target="_blank" class="pth-btn-chat">
                                <i class="fa-solid fa-comment-dots"></i> Live Chat
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="pth-faq-box">
                            <div class="pth-faq-title">Frequently Asked Questions</div>

                            <div class="pth-faq-item">
                                <div class="pth-faq-q">How quickly can a physio arrive?</div>
                                <div class="pth-faq-a">Same-day appointments are available based on doctor availability in your locality.</div>
                            </div>

                            <div class="pth-faq-item">
                                <div class="pth-faq-q">Is home physiotherapy as effective?</div>
                                <div class="pth-faq-a">Yes, tailored one-on-one sessions at home often lead to faster, more sustainable recovery in familiar surroundings.</div>
                            </div>

                            <div class="pth-faq-item">
                                <div class="pth-faq-q">What gear/tools are required?</div>
                                <div class="pth-faq-a">Our physiotherapists arrive equipped with necessary portable therapy equipment.</div>
                            </div>

                            <a href="mailto:support@physiopii.com" class="pth-btn-support-email">
                                <i class="fa-regular fa-envelope"></i> support@physiopii.com
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         FOOTER (Dark Navy)
    ══════════════════════════════════════════════════ --}}
    <footer class="pth-footer">
        <div class="home-container">

            <div class="pth-footer-grid">
                <div>
                    <a href="{{ route('home') }}" class="pth-footer-brand">
                        <img src="{{ asset('logo.png') }}" alt="PhysioPii" style="height:40px;width:auto;object-fit:contain;display:block;filter:brightness(0) invert(1);">
                    </a>
                    <p class="pth-footer-about">
                        Bringing professional, trusted physical therapy directly to your doorstep. Experience personalized pain recovery and health comfort.
                    </p>
                </div>

                <div>
                    <div class="pth-footer-heading">Our Services</div>
                    <ul class="pth-footer-links">
                        <li><a href="#specialists">Back Pain Relief</a></li>
                        <li><a href="#specialists">Joint Rehabilitation</a></li>
                        <li><a href="#specialists">Stroke Recovery Programs</a></li>
                        <li><a href="#specialists">Post-Operative Training</a></li>
                    </ul>
                </div>

                <div>
                    <div class="pth-footer-heading">Quick Links</div>
                    <ul class="pth-footer-links">
                        <li><a href="#how-it-works">About Us</a></li>
                        <li><a href="{{ route('login') }}">Become a Partner Doctor</a></li>
                        <li><a href="#specialists">Verified Patient Reviews</a></li>
                        <li><a href="#how-it-works">Help &amp; FAQs</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div>
                    <div class="pth-footer-heading">Contact</div>
                    <ul class="pth-footer-links">
                        <li><a href="mailto:support@physiopii.com">support@physiopii.com</a></li>
                        <li><a href="tel:+919513211470">1-800-PHYSIO-HOME</a></li>
                        <li><span style="font-size:13.5px;color:#94a3b8;">Western Pearl Building, Central</span></li>
                    </ul>
                </div>
            </div>

            <div class="pth-footer-bottom">
                <div>&copy; {{ date('Y') }} Physiopii Inc. All rights reserved.</div>
                <div class="pth-social-row">
                    <a href="#" class="pth-social-link"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="pth-social-link"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="pth-social-link"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" class="pth-social-link"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

        </div>
    </footer>

</div>{{-- /main-wrapper --}}

<script>
// Dictionary mapping popular conditions to doctor keywords
const conditionKeywords = {
    'Back Pain': ['back', 'spine', 'lumbar', 'sciatica', 'posture', 'disc', 'ortho', 'pain', 'rehab', 'physio'],
    'Neck Pain': ['neck', 'cervical', 'spine', 'shoulder', 'posture', 'ortho', 'pain', 'rehab', 'physio'],
    'Knee Pain': ['knee', 'joint', 'acl', 'arthritis', 'osteoarthritis', 'cartilage', 'ortho', 'sports', 'physio'],
    'Shoulder Pain': ['shoulder', 'frozen', 'rotator', 'joint', 'arm', 'ortho', 'sports', 'physio'],
    'Hip Pain': ['hip', 'joint', 'pelvic', 'pelvis', 'arthritis', 'groin', 'mobility', 'ortho', 'physio']
};

let activeCondition = null;

function toggleConditionFilter(conditionName, cardElement) {
    const input = document.getElementById('doctorSearch');
    const allCards = document.querySelectorAll('.pth-cond-card');
    const clearBtn = document.getElementById('clearPopCondBtn');

    // If clicking the currently active card, toggle off (reset)
    if (activeCondition === conditionName) {
        clearConditionFilter();
        return;
    }

    activeCondition = conditionName;

    // Highlight card
    allCards.forEach(c => {
        if (c.getAttribute('data-condition') === conditionName) {
            c.classList.add('active');
        } else {
            c.classList.remove('active');
        }
    });

    if (clearBtn) clearBtn.style.display = 'inline-flex';

    // Update search box
    if (input) {
        input.value = conditionName;
    }

    // Filter doctor cards on page
    applyDoctorFilter(conditionName);

    // Smooth scroll down to doctors list
    const docSection = document.getElementById('specialists');
    if (docSection) {
        docSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function clearConditionFilter() {
    activeCondition = null;
    const input = document.getElementById('doctorSearch');
    const allCards = document.querySelectorAll('.pth-cond-card');
    const clearBtn = document.getElementById('clearPopCondBtn');
    const filterBanner = document.getElementById('pth-filter-banner');
    const noDocsBanner = document.getElementById('pthNoDoctors');

    allCards.forEach(c => c.classList.remove('active'));
    if (clearBtn) clearBtn.style.display = 'none';
    if (filterBanner) filterBanner.style.display = 'none';
    if (noDocsBanner) noDocsBanner.style.display = 'none';

    if (input) input.value = '';

    // Show all doctor cards
    const docCards = document.querySelectorAll('.pth-doctor-card');
    docCards.forEach(card => card.style.display = 'flex');
}

function applyDoctorFilter(conditionName) {
    const filterBanner = document.getElementById('pth-filter-banner');
    const activeText = document.getElementById('pth-active-filter-text');
    const filterCount = document.getElementById('pth-filter-count');
    const noDocsBanner = document.getElementById('pthNoDoctors');
    const docCards = document.querySelectorAll('.pth-doctor-card');

    if (!docCards.length) return;

    const keywords = conditionKeywords[conditionName] || [conditionName.toLowerCase()];
    let visibleCount = 0;

    docCards.forEach(card => {
        const text = (card.getAttribute('data-keywords') || '') + ' ' + 
                     (card.getAttribute('data-spec') || '') + ' ' +
                     (card.getAttribute('data-qual') || '') + ' ' +
                     (card.getAttribute('data-name') || '');

        const matches = keywords.some(k => text.includes(k.toLowerCase()));

        if (matches) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // If none matched specific keywords, show all with note
    if (visibleCount === 0) {
        docCards.forEach(card => card.style.display = 'flex');
        visibleCount = docCards.length;
        if (noDocsBanner) noDocsBanner.style.display = 'block';
    } else {
        if (noDocsBanner) noDocsBanner.style.display = 'none';
    }

    if (filterBanner && activeText) {
        activeText.textContent = conditionName;
        if (filterCount) {
            filterCount.textContent = `(${visibleCount} specialist${visibleCount === 1 ? '' : 's'} available)`;
        }
        filterBanner.style.display = 'flex';
    }
}

// Live Autocomplete Search + Direct filter on input
(function() {
    const input = document.getElementById('doctorSearch');
    const dropdown = document.getElementById('hp-doctor-dropdown');
    const searchSubmitBtn = document.getElementById('searchSubmitBtn');
    if (!input) return;

    let debounceTimer;

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();

        // If emptied, reset filters
        if (!q) {
            clearConditionFilter();
            if (dropdown) {
                dropdown.innerHTML = '';
                dropdown.classList.remove('open');
            }
            return;
        }

        debounceTimer = setTimeout(() => {
            // Live Autocomplete
            if (dropdown && q.length >= 2) {
                fetch(`/search-doctors?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data || !data.length) {
                            dropdown.innerHTML = `
                                <div style="padding:14px 18px;color:#64748b;font-size:13px;">
                                    No direct doctor matches found. Showing nearby physiotherapists.
                                </div>
                            `;
                            dropdown.classList.add('open');
                            return;
                        }

                        dropdown.innerHTML = data.slice(0, 6).map(doc => {
                            const spec = (doc.profile && doc.profile.specializationdata && doc.profile.specializationdata.name)
                                ? doc.profile.specializationdata.name
                                : 'Physiotherapist';
                            const initial = doc.name ? doc.name.charAt(0).toUpperCase() : 'D';

                            return `
                                <a href="/doctor/${doc.id}">
                                    <div style="display:flex;align-items:center;gap:12px">
                                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#0c6978,#2dd4bf);color:#fff;font-size:14px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                            ${initial}
                                        </div>
                                        <div>
                                            <div style="font-size:14px;font-weight:800;color:#0f172a">Dr. ${doc.name}</div>
                                            <div style="font-size:12px;color:#64748b;margin-top:1px">${spec}</div>
                                        </div>
                                    </div>
                                    <span style="font-size:12px;font-weight:700;color:#0c6978;">View Profile &rarr;</span>
                                </a>
                            `;
                        }).join('');
                        dropdown.classList.add('open');
                    })
                    .catch(() => {});
            }

            // Also filter doctor cards dynamically
            const query = q.toLowerCase();
            const docCards = document.querySelectorAll('.pth-doctor-card');
            docCards.forEach(card => {
                const text = (card.getAttribute('data-keywords') || '') + ' ' + 
                             (card.getAttribute('data-spec') || '') + ' ' +
                             (card.getAttribute('data-qual') || '') + ' ' +
                             (card.getAttribute('data-name') || '');
                card.style.display = text.includes(query) ? 'flex' : 'none';
            });
        }, 220);
    });

    if (searchSubmitBtn) {
        searchSubmitBtn.addEventListener('click', function() {
            const q = input.value.trim();
            if (q) {
                const docSection = document.getElementById('specialists');
                if (docSection) {
                    docSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (dropdown && !input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });

    // Mobile nav toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.querySelector('.pth-nav-links');
    if (mobileBtn && navLinks) {
        mobileBtn.addEventListener('click', function() {
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '100%';
                navLinks.style.left = '0';
                navLinks.style.right = '0';
                navLinks.style.background = '#ffffff';
                navLinks.style.padding = '20px';
                navLinks.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
            }
        });
    }
})();

// Enquiry Modal Functions
function openEnquiryModal() {
    const overlay = document.getElementById('enquiryModalOverlay');
    if (overlay) {
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeEnquiryModal() {
    const overlay = document.getElementById('enquiryModalOverlay');
    if (overlay) {
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function toggleOtherSymptom(val) {
    const group = document.getElementById('otherSymptomGroup');
    const input = document.getElementById('enq_other_symptom');
    if (val === 'Other') {
        group.style.display = 'flex';
        input.setAttribute('required', 'required');
        input.focus();
    } else {
        group.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
    }
}

function handleEnquirySubmit(e) {
    e.preventDefault();
    const form = document.getElementById('enquiryForm');
    const btn = document.getElementById('enquirySubmitBtn');
    const btnText = document.getElementById('enqBtnText');
    const btnSpinner = document.getElementById('enqBtnSpinner');
    const errorBox = document.getElementById('enquiryErrorBox');
    const successBox = document.getElementById('enquirySuccessBox');
    const successMsg = document.getElementById('enquirySuccessMsg');

    errorBox.classList.add('hidden');
    errorBox.innerHTML = '';
    btn.disabled = true;
    btnText.style.display = 'none';
    btnSpinner.style.display = 'inline-block';

    const formData = new FormData(form);

    fetch("{{ route('enquiry.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(async (response) => {
        const data = await response.json();
        btn.disabled = false;
        btnText.style.display = 'inline-flex';
        btnSpinner.style.display = 'none';

        if (response.ok && data.success) {
            form.style.display = 'none';
            if (data.message) {
                successMsg.textContent = data.message;
            }
            successBox.classList.remove('hidden');
            form.reset();
        } else {
            let msg = data.message || 'Please fill in all required fields.';
            if (data.errors) {
                msg = Object.values(data.errors).flat().join('<br>');
            }
            errorBox.innerHTML = msg;
            errorBox.classList.remove('hidden');
        }
    })
    .catch((err) => {
        btn.disabled = false;
        btnText.style.display = 'inline-flex';
        btnSpinner.style.display = 'none';
        errorBox.innerHTML = 'An unexpected error occurred. Please try again or call support.';
        errorBox.classList.remove('hidden');
    });
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEnquiryModal();
    }
});
</script>

{{-- ══════════════════════════════════════════════════
     HOME VISIT ENQUIRY MODAL
══════════════════════════════════════════════════ --}}
<div class="pth-enquiry-overlay hidden" id="enquiryModalOverlay" onclick="if(event.target===this)closeEnquiryModal()">
    <div class="pth-enquiry-modal" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div class="pth-enquiry-header">
            <div class="pth-enquiry-header-left">
                <div class="pth-enquiry-icon">
                    <i class="fa-solid fa-house-medical"></i>
                </div>
                <div>
                    <h3 class="pth-enquiry-title">Book Home Visit Consultation</h3>
                    <p class="pth-enquiry-sub">Get certified physiotherapist at your doorstep</p>
                </div>
            </div>
            <button type="button" class="pth-enquiry-close" onclick="closeEnquiryModal()" aria-label="Close">&times;</button>
        </div>

        <!-- Success Message Box -->
        <div id="enquirySuccessBox" class="pth-enquiry-success hidden">
            <div class="pth-enquiry-success-icon"><i class="fa-solid fa-circle-check"></i></div>
            <h4>Enquiry Submitted Successfully!</h4>
            <p id="enquirySuccessMsg">Our care coordinator will contact you shortly to confirm your home visit timing.</p>
            <button type="button" class="pth-btn-teal" onclick="closeEnquiryModal()" style="margin-top:14px;">Done</button>
        </div>

        <!-- Form Body -->
        <form id="enquiryForm" method="POST" action="{{ route('enquiry.store') }}" onsubmit="handleEnquirySubmit(event)">
            @csrf
            <div class="pth-enquiry-body">

                <!-- Alert error box -->
                <div id="enquiryErrorBox" class="pth-enquiry-error hidden"></div>

                <!-- Patient Name -->
                <div class="pth-form-group">
                    <label class="pth-form-label" for="enq_patient_name">Patient Full Name <span class="req">*</span></label>
                    <div class="pth-input-wrap">
                        <i class="fa-regular fa-user pth-input-icon"></i>
                        <input type="text" id="enq_patient_name" name="patient_name" class="pth-form-input" 
                               value="{{ Auth::check() ? Auth::user()->name : old('patient_name') }}" 
                               placeholder="e.g. Rahul Sharma" required>
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="pth-form-group">
                    <label class="pth-form-label" for="enq_contact_number">Mobile / WhatsApp Number <span class="req">*</span></label>
                    <div class="pth-input-wrap">
                        <i class="fa-solid fa-phone pth-input-icon"></i>
                        <input type="tel" id="enq_contact_number" name="contact_number" class="pth-form-input" 
                               value="{{ Auth::check() ? Auth::user()->phone : old('contact_number') }}" 
                               placeholder="e.g. 9876543210" required>
                    </div>
                </div>

                <!-- Condition / Reason for Visit -->
                <div class="pth-form-group">
                    <label class="pth-form-label" for="enq_symptoms">Condition / Reason for Home Visit <span class="req">*</span></label>
                    <div class="pth-input-wrap">
                        <i class="fa-solid fa-notes-medical pth-input-icon"></i>
                        <select id="enq_symptoms" name="symptoms" class="pth-form-select" onchange="toggleOtherSymptom(this.value)">
                            <option value="Back Pain & Sciatica">Back Pain &amp; Sciatica</option>
                            <option value="Neck & Shoulder Pain">Neck &amp; Shoulder Pain</option>
                            <option value="Knee & Joint Pain">Knee &amp; Joint Pain / Arthritis</option>
                            <option value="Post Surgery Rehabilitation">Post Surgery Rehabilitation</option>
                            <option value="Stroke / Paralysis Rehab">Stroke / Paralysis Neuro Rehab</option>
                            <option value="Sports Injury Recovery">Sports Injury Recovery</option>
                            <option value="Elderly Mobility & Fall Prevention">Elderly Mobility &amp; Fall Prevention</option>
                            <option value="Spine & Posture Care">Spine &amp; Posture Care</option>
                            <option value="General Physiotherapy">General Physiotherapy Consultation</option>
                            <option value="Other">Other Condition…</option>
                        </select>
                    </div>
                </div>

                <!-- Other Symptom Input -->
                <div class="pth-form-group" id="otherSymptomGroup" style="display:none;">
                    <label class="pth-form-label" for="enq_other_symptom">Specify Condition Details</label>
                    <input type="text" id="enq_other_symptom" name="other_symptom" class="pth-form-input" placeholder="Describe the pain or condition...">
                </div>

                <!-- Location / Address -->
                <div class="pth-form-group">
                    <label class="pth-form-label" for="enq_location">Home Address / Locality / City <span class="req">*</span></label>
                    <div class="pth-input-wrap">
                        <i class="fa-solid fa-location-dot pth-input-icon"></i>
                        <input type="text" id="enq_location" name="location" class="pth-form-input" 
                               value="{{ Auth::check() ? Auth::user()->address : old('location') }}" 
                               placeholder="e.g. Flat 302, Sector 14, Gurugram" required>
                    </div>
                </div>

                <!-- Additional Notes (Optional) -->
                <div class="pth-form-group">
                    <label class="pth-form-label" for="enq_notes">Additional Notes / Preferred Time <span class="opt">(Optional)</span></label>
                    <textarea id="enq_notes" name="notes" class="pth-form-textarea" rows="2" placeholder="Any specific requirements, doctor gender preference, or convenient time..."></textarea>
                </div>

                <!-- Trust Points -->
                <div class="pth-enquiry-trust-row">
                    <div class="pth-trust-item"><i class="fa-solid fa-shield-halved"></i> Certified Physios</div>
                    <div class="pth-trust-item"><i class="fa-solid fa-clock"></i> 15-Min Callback</div>
                    <div class="pth-trust-item"><i class="fa-solid fa-house-chimney"></i> At Your Home</div>
                </div>

            </div>

            <!-- Footer -->
            <div class="pth-enquiry-footer">
                <button type="button" class="pth-btn-ghost" onclick="closeEnquiryModal()">Cancel</button>
                <button type="submit" class="pth-btn-teal" id="enquirySubmitBtn">
                    <span id="enqBtnText">Request Home Visit <i class="fa-solid fa-arrow-right"></i></span>
                    <span id="enqBtnSpinner" class="spinner-border spinner-border-sm" style="display:none;width:16px;height:16px;border-width:2px;"></span>
                </button>
            </div>
        </form>

    </div>
</div>

@endsection