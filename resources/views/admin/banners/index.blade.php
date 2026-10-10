@extends('admin.layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
  --bg:         #EEF4FB;
  --white:      #FFFFFF;
  --blue:       #2260FF;
  --blue-l:     #EBF2FF;
  --blue-d:     #164ED9;
  --border:     #D6E4F5;
  --text:       #0F1E3A;
  --text2:      #3D5278;
  --text3:      #7A92B8;
  --green:      #10B981;
  --green-bg:   #E8F8F2;
  --rose:       #EF4444;
  --rose-bg:    #FDEEF0;
  --amber:      #F59E0B;
  --amber-bg:   #FEF5E7;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

.banner-page {
  padding: 28px 28px 48px;
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  min-height: 100vh;
}

.page-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 24px;
}
.page-eyebrow {
  font-size: 11px;
  font-weight: 700;
  color: var(--blue);
  text-transform: uppercase;
  letter-spacing: .8px;
  margin-bottom: 4px;
}
.page-title {
  font-size: 24px;
  font-weight: 800;
  color: var(--text);
  letter-spacing: -.4px;
  margin: 0;
}
.page-subtitle {
  font-size: 13.5px;
  color: var(--text2);
  margin-top: 4px;
}

/* ── STATS ROW ── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.stat-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 2px 6px rgba(34, 96, 255, 0.04);
}
.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 11px;
  background: var(--blue-l);
  color: var(--blue);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}
.stat-info h4 {
  font-size: 20px;
  font-weight: 800;
  color: var(--text);
  margin: 0;
}
.stat-info p {
  font-size: 12px;
  color: var(--text3);
  margin: 2px 0 0;
  font-weight: 600;
}

/* ── PANEL ── */
.panel {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(15, 30, 58, 0.04);
  position: relative;
  margin-bottom: 24px;
}
.panel::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--blue), #06b6d4);
}
.panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 24px;
  border-bottom: 1px solid var(--border);
}
.panel-head-left {
  display: flex;
  align-items: center;
  gap: 12px;
}
.panel-icon {
  width: 36px;
  height: 36px;
  background: var(--blue-l);
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--blue);
  font-size: 16px;
}
.panel-title {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
  margin: 0;
}
.panel-body {
  padding: 24px;
}

/* ── FORM ELEMENTS ── */
.form-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 18px;
}
.field-col-12 { grid-column: span 12; }
.field-col-8  { grid-column: span 8; }
.field-col-6  { grid-column: span 6; }
.field-col-4  { grid-column: span 4; }
.field-col-3  { grid-column: span 3; }

@media(max-width: 900px) {
  .field-col-8, .field-col-6, .field-col-4, .field-col-3 {
    grid-column: span 12;
  }
}

.field-label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  color: var(--text2);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 7px;
}
.field-label span {
  color: var(--rose);
}
.field-input, .field-textarea, .field-select {
  width: 100%;
  background: var(--bg);
  border: 1.5px solid var(--border);
  border-radius: 10px;
  padding: 10px 14px;
  font-family: 'Inter', sans-serif;
  font-size: 13.5px;
  font-weight: 500;
  color: var(--text);
  outline: none;
  transition: all .2s var(--ease);
}
.field-input:focus, .field-textarea:focus, .field-select:focus {
  border-color: var(--blue);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(34, 96, 255, 0.12);
}
.field-hint {
  font-size: 11.5px;
  color: var(--text3);
  margin-top: 5px;
}

/* File Upload Box */
.file-upload-box {
  border: 2px dashed #B8CCE8;
  border-radius: 12px;
  padding: 18px;
  text-align: center;
  background: #F7FAFF;
  cursor: pointer;
  position: relative;
  transition: all .2s ease;
}
.file-upload-box:hover {
  border-color: var(--blue);
  background: #EBF2FF;
}
.file-upload-box input[type="file"] {
  position: absolute;
  top: 0; left: 0; width: 100%; height: 100%;
  opacity: 0;
  cursor: pointer;
}
.file-upload-box .upload-icon {
  font-size: 26px;
  color: var(--blue);
  margin-bottom: 6px;
}
.file-upload-box .upload-text {
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
}
.file-upload-box .upload-sub {
  font-size: 11.5px;
  color: var(--text3);
  margin-top: 2px;
}
.image-preview-holder {
  margin-top: 12px;
  border-radius: 10px;
  overflow: hidden;
  max-height: 150px;
  display: none;
  background: #000;
}
.image-preview-holder img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  display: block;
}

/* Buttons */
.btn-primary-blue {
  background: linear-gradient(135deg, var(--blue), var(--blue-d));
  color: #fff;
  border: none;
  padding: 11px 24px;
  border-radius: 10px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 14px rgba(34, 96, 255, 0.28);
  transition: all .2s ease;
}
.btn-primary-blue:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(34, 96, 255, 0.38);
}

/* ── TABLE LIST ── */
.table-responsive {
  overflow-x: auto;
}
.banner-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}
.banner-table th {
  background: #F4F8FD;
  font-size: 11px;
  font-weight: 700;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: .6px;
  padding: 13px 18px;
  border-bottom: 1.5px solid var(--border);
  text-align: left;
}
.banner-table td {
  padding: 16px 18px;
  font-size: 13px;
  color: var(--text);
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}
.banner-table tr:last-child td {
  border-bottom: none;
}
.banner-table tr:hover td {
  background: #F9FBFF;
}

/* Banner preview thumb */
.banner-thumb-cell {
  position: relative;
  width: 160px;
  min-width: 160px;
}
.banner-thumb-img {
  width: 150px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  display: block;
  border: 1px solid var(--border);
}
.badge-time {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: var(--amber-bg);
  color: var(--amber);
  border: 1px solid rgba(245, 158, 11, 0.25);
  padding: 3px 9px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
}
.badge-status {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.badge-active {
  background: var(--green-bg);
  color: var(--green);
  border: 1px solid rgba(16, 185, 129, 0.25);
}
.badge-inactive {
  background: var(--rose-bg);
  color: var(--rose);
  border: 1px solid rgba(239, 68, 68, 0.25);
}

.action-btn-group {
  display: flex;
  align-items: center;
  gap: 8px;
}
.action-btn {
  width: 34px;
  height: 34px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: #fff;
  color: var(--text2);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all .15s ease;
  font-size: 13px;
}
.action-btn:hover {
  background: var(--blue-l);
  color: var(--blue);
  border-color: var(--blue);
}
.action-btn.delete-btn:hover {
  background: var(--rose-bg);
  color: var(--rose);
  border-color: var(--rose);
}

/* ── MODAL ── */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(15, 30, 58, 0.6);
  backdrop-filter: blur(4px);
  z-index: 9999;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.modal-card {
  background: #fff;
  border-radius: 18px;
  max-width: 750px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
  animation: modalFadeIn .25s ease-out;
}
@keyframes modalFadeIn {
  from { opacity: 0; transform: translateY(12px) scale(0.98); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-header {
  padding: 20px 24px;
  border-bottom: 1.5px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-header h3 {
  font-size: 17px;
  font-weight: 800;
  color: var(--text);
  margin: 0;
}
.modal-close {
  background: transparent;
  border: none;
  font-size: 20px;
  color: var(--text3);
  cursor: pointer;
  line-height: 1;
}
.modal-close:hover {
  color: var(--rose);
}
.modal-body {
  padding: 24px;
}
.modal-footer {
  padding: 16px 24px;
  border-top: 1.5px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: #F8FAFD;
}
.btn-secondary {
  background: #E8EEF7;
  color: var(--text2);
  border: none;
  padding: 10px 20px;
  border-radius: 9px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}
</style>

<div class="banner-page">

    {{-- Top Header --}}
    <div class="page-head">
        <div>
            <div class="page-eyebrow">Homepage Configuration</div>
            <h1 class="page-title">Hero Section Slider Banners</h1>
            <div class="page-subtitle">Upload full-width banner images, titles, timing badges, and descriptions for the homepage hero carousel.</div>
        </div>
        <div>
            <a href="{{ route('home') }}" target="_blank" class="btn-primary-blue" style="text-decoration:none;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Homepage
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div style="background:var(--green-bg); border:1px solid rgba(16,185,129,0.3); border-radius:12px; padding:14px 20px; color:var(--green); font-weight:600; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check" style="font-size:16px;"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:var(--rose-bg); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:14px 20px; color:var(--rose); font-weight:600; margin-bottom:20px;">
            <div style="font-weight:700; margin-bottom:5px;">Please correct the following errors:</div>
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-images"></i></div>
            <div class="stat-info">
                <h4>{{ $banners->count() }}</h4>
                <p>Total Hero Banners</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#E8F8F2; color:#10B981;"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <h4>{{ $banners->where('status', 'active')->count() }}</h4>
                <p>Active Live Slides</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF5E7; color:#F59E0B;"><i class="fa-solid fa-sliders"></i></div>
            <div class="stat-info">
                <h4>Full-Width</h4>
                <p>Hero Slider Mode</p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         ADD NEW BANNER PANEL
    ══════════════════════════════════════════════════ --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fa-solid fa-plus"></i></div>
                <h3 class="panel-title">Add New Hero Banner Slide</h3>
            </div>
            <span style="font-size:12px; font-weight:600; color:var(--text3);">Recommended Image: 1920 × 650px</span>
        </div>

        <div class="panel-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    {{-- 1. Image Upload --}}
                    <div class="field-col-12">
                        <label class="field-label">Banner Image <span>*</span></label>
                        <div class="file-upload-box" id="newBannerUploadBox">
                            <input type="file" name="image" id="newBannerImageInput" accept="image/*" required>
                            <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                            <div class="upload-text">Click or drag banner image here to upload</div>
                            <div class="upload-sub">Supports JPG, PNG, WEBP, GIF (Max 5MB). High resolution landscape image recommended.</div>
                        </div>
                        <div class="image-preview-holder" id="newBannerPreviewHolder">
                            <img src="" id="newBannerPreviewImg" alt="Banner Preview">
                        </div>
                    </div>

                    {{-- 2. Title / Heading --}}
                    <div class="field-col-8">
                        <label class="field-label">Banner Title / Heading <span>*</span></label>
                        <input type="text" name="title" class="field-input" placeholder="e.g. A stronger comeback. One step at a time." required>
                        <div class="field-hint">The main headline displayed prominently on the hero slider.</div>
                    </div>

                    {{-- 3. Time / Timing Badge --}}
                    <div class="field-col-4">
                        <label class="field-label">Time / Timing / Badge</label>
                        <input type="text" name="time" class="field-input" placeholder="e.g. Available 24/7 or 7 AM - 9 PM">
                        <div class="field-hint">Displays as an animated eyebrow tag (e.g. service hours or promo time).</div>
                    </div>

                    {{-- 4. Description --}}
                    <div class="field-col-12">
                        <label class="field-label">Description / Subtitle</label>
                        <textarea name="description" class="field-textarea" rows="3" placeholder="From your first pain-free walk to your next finish line, connect with certified specialists who put your recovery first."></textarea>
                    </div>

                    {{-- 5. Button 1 --}}
                    <div class="field-col-3">
                        <label class="field-label">Primary Button Text</label>
                        <input type="text" name="button_text" class="field-input" value="Book Appointment">
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Primary Button Link</label>
                        <input type="text" name="button_link" class="field-input" value="#search-bar">
                    </div>

                    {{-- 6. Button 2 --}}
                    <div class="field-col-3">
                        <label class="field-label">Secondary Button Text</label>
                        <input type="text" name="button_text_2" class="field-input" value="Find Physiotherapist">
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Secondary Button Link</label>
                        <input type="text" name="button_link_2" class="field-input" value="#specialists">
                    </div>

                    {{-- 7. Display Order & Status --}}
                    <div class="field-col-3">
                        <label class="field-label">Display Order</label>
                        <input type="number" name="order" class="field-input" value="0" min="0">
                        <div class="field-hint">0 shows first, then 1, 2, 3...</div>
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Status</label>
                        <select name="status" class="field-select">
                            <option value="active">Active (Visible on Homepage)</option>
                            <option value="inactive">Inactive (Draft)</option>
                        </select>
                    </div>

                    <div class="field-col-6" style="display:flex; align-items:flex-end;">
                        <button type="submit" class="btn-primary-blue" style="width:100%; justify-content:center; padding:12px;">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Upload &amp; Publish Hero Banner
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         EXISTING BANNERS LIST
    ══════════════════════════════════════════════════ --}}
    <div class="panel">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-icon"><i class="fa-solid fa-list-check"></i></div>
                <h3 class="panel-title">Configured Hero Banners ({{ $banners->count() }})</h3>
            </div>
        </div>

        <div class="panel-body" style="padding:0;">
            <div class="table-responsive">
                <table class="banner-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">Order</th>
                            <th>Banner Image</th>
                            <th>Title &amp; Time / Badge</th>
                            <th>Description</th>
                            <th>Buttons</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                            <tr>
                                <td>
                                    <span style="font-weight:700; color:var(--text3); font-size:14px;">#{{ $banner->order }}</span>
                                </td>
                                <td class="banner-thumb-cell">
                                    <img src="{{ $banner->image_url }}" class="banner-thumb-img" alt="{{ $banner->title }}">
                                </td>
                                <td>
                                    <div style="font-weight:700; font-size:14px; color:var(--text); margin-bottom:4px;">
                                        {{ $banner->title ?: 'Untitled Banner' }}
                                    </div>
                                    @if($banner->time)
                                        <span class="badge-time">
                                            <i class="fa-regular fa-clock"></i> {{ $banner->time }}
                                        </span>
                                    @endif
                                </td>
                                <td style="max-width:280px;">
                                    <div style="color:var(--text2); font-size:12.5px; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                        {{ $banner->description ?: 'No description' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size:11.5px; color:var(--text3);">
                                        <div><strong style="color:var(--text2);">Btn 1:</strong> {{ $banner->button_text }} ({{ $banner->button_link }})</div>
                                        <div><strong style="color:var(--text2);">Btn 2:</strong> {{ $banner->button_text_2 }} ({{ $banner->button_link_2 }})</div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.banners.toggle', $banner->id) }}" style="text-decoration:none;" title="Click to toggle status">
                                        @if($banner->status == 'active')
                                            <span class="badge-status badge-active"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Active</span>
                                        @else
                                            <span class="badge-status badge-inactive"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Inactive</span>
                                        @endif
                                    </a>
                                </td>
                                <td style="text-align:right;">
                                    <div class="action-btn-group" style="justify-content:flex-end;">
                                        {{-- Edit Button --}}
                                        <button type="button" class="action-btn edit-banner-btn"
                                            data-id="{{ $banner->id }}"
                                            data-title="{{ $banner->title }}"
                                            data-time="{{ $banner->time }}"
                                            data-description="{{ $banner->description }}"
                                            data-button-text="{{ $banner->button_text }}"
                                            data-button-link="{{ $banner->button_link }}"
                                            data-button-text-2="{{ $banner->button_text_2 }}"
                                            data-button-link-2="{{ $banner->button_link_2 }}"
                                            data-order="{{ $banner->order }}"
                                            data-status="{{ $banner->status }}"
                                            data-image-url="{{ $banner->image_url }}"
                                            data-update-url="{{ route('admin.banners.update', $banner->id) }}"
                                            title="Edit Banner">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hero banner?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" title="Delete Banner">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:40px 20px; color:var(--text3);">
                                    <i class="fa-solid fa-images" style="font-size:36px; margin-bottom:12px; color:#B8CCE8;"></i>
                                    <div style="font-size:15px; font-weight:700; color:var(--text2);">No hero banners uploaded yet</div>
                                    <div style="font-size:12.5px; margin-top:4px;">The homepage is currently using default high-resolution curated slides. Use the form above to upload your first custom hero banner!</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     EDIT BANNER MODAL
══════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="editBannerModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Edit Hero Banner</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>

        <form id="editBannerForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div class="form-grid">
                    
                    {{-- Current image preview --}}
                    <div class="field-col-12">
                        <label class="field-label">Current Banner Image</label>
                        <div style="border-radius:10px; overflow:hidden; max-height:160px; background:#000; margin-bottom:10px;">
                            <img id="editCurrentImgPreview" src="" alt="Current Banner" style="width:100%; height:160px; object-fit:cover;">
                        </div>
                        <label class="field-label">Replace Banner Image (Optional)</label>
                        <input type="file" name="image" id="editImageInput" class="field-input" accept="image/*">
                        <div class="field-hint">Leave blank to keep the current banner image.</div>
                    </div>

                    {{-- Title --}}
                    <div class="field-col-8">
                        <label class="field-label">Banner Title / Heading <span>*</span></label>
                        <input type="text" name="title" id="editTitle" class="field-input" required>
                    </div>

                    {{-- Time / Badge --}}
                    <div class="field-col-4">
                        <label class="field-label">Time / Timing / Badge</label>
                        <input type="text" name="time" id="editTime" class="field-input" placeholder="e.g. Available 24/7">
                    </div>

                    {{-- Description --}}
                    <div class="field-col-12">
                        <label class="field-label">Description</label>
                        <textarea name="description" id="editDescription" class="field-textarea" rows="3"></textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="field-col-3">
                        <label class="field-label">Primary Button Text</label>
                        <input type="text" name="button_text" id="editBtnText" class="field-input">
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Primary Button Link</label>
                        <input type="text" name="button_link" id="editBtnLink" class="field-input">
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Secondary Button Text</label>
                        <input type="text" name="button_text_2" id="editBtnText2" class="field-input">
                    </div>
                    <div class="field-col-3">
                        <label class="field-label">Secondary Button Link</label>
                        <input type="text" name="button_link_2" id="editBtnLink2" class="field-input">
                    </div>

                    {{-- Order & Status --}}
                    <div class="field-col-6">
                        <label class="field-label">Display Order</label>
                        <input type="number" name="order" id="editOrder" class="field-input" min="0">
                    </div>
                    <div class="field-col-6">
                        <label class="field-label">Status</label>
                        <select name="status" id="editStatus" class="field-select">
                            <option value="active">Active (Visible)</option>
                            <option value="inactive">Inactive (Draft)</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-primary-blue">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Live image preview for New Banner
    var newImgInput = document.getElementById('newBannerImageInput');
    var newPreviewHolder = document.getElementById('newBannerPreviewHolder');
    var newPreviewImg = document.getElementById('newBannerPreviewImg');

    if (newImgInput) {
        newImgInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    newPreviewImg.src = e.target.result;
                    newPreviewHolder.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // 2. Edit Modal Population
    var editBtns = document.querySelectorAll('.edit-banner-btn');
    var modal = document.getElementById('editBannerModal');
    var form = document.getElementById('editBannerForm');

    editBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.action = this.getAttribute('data-update-url');
            document.getElementById('editTitle').value = this.getAttribute('data-title') || '';
            document.getElementById('editTime').value = this.getAttribute('data-time') || '';
            document.getElementById('editDescription').value = this.getAttribute('data-description') || '';
            document.getElementById('editBtnText').value = this.getAttribute('data-button-text') || '';
            document.getElementById('editBtnLink').value = this.getAttribute('data-button-link') || '';
            document.getElementById('editBtnText2').value = this.getAttribute('data-button-text-2') || '';
            document.getElementById('editBtnLink2').value = this.getAttribute('data-button-link-2') || '';
            document.getElementById('editOrder').value = this.getAttribute('data-order') || 0;
            document.getElementById('editStatus').value = this.getAttribute('data-status') || 'active';
            document.getElementById('editCurrentImgPreview').src = this.getAttribute('data-image-url') || '';

            modal.style.display = 'flex';
        });
    });

    // Close modal on click outside
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeEditModal();
        }
    });
});

function closeEditModal() {
    var modal = document.getElementById('editBannerModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>

@endsection
