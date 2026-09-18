@extends('admin.layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
  --bg:         #EEF4FB;
  --white:      #FFFFFF;
  --blue:       #2D7DD2;
  --blue-l:     #E8F1FB;
  --blue-d:     #1A5BA8;
  --blue-mid:   #4A9AE8;
  --border:     #D6E4F5;
  --text:       #1A2B42;
  --text2:      #4A6080;
  --text3:      #8FA8C4;
  --amber:      #D08020;
  --amber-d:    #9A5C10;
  --neutral-bg: #F2F5F8;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}
*{ box-sizing:border-box; }

.form-page{
  padding:28px 28px 48px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

.breadcrumb-row{ display:flex;align-items:center;gap:6px;margin-bottom:16px; }
.breadcrumb-row a{ font-size:12.5px;font-weight:600;color:var(--blue);text-decoration:none;transition:opacity .2s; }
.breadcrumb-row a:hover{ opacity:.75; }
.breadcrumb-sep{ font-size:12px;color:var(--text3); }
.breadcrumb-cur{ font-size:12.5px;font-weight:600;color:var(--text3); }

.page-eyebrow{ font-size:11px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px; }
.page-title{ font-size:22px;font-weight:700;color:var(--text);letter-spacing:-.3px;margin-bottom:22px; }
.page-title span{ font-weight:300;color:var(--text2); }

.panel{
  background:var(--white);border:1px solid var(--border);
  border-radius:16px;overflow:hidden;
  box-shadow:0 2px 8px rgba(45,125,210,.05),0 10px 32px rgba(26,91,168,.07);
  position:relative;max-width:720px;
}
.panel::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--amber-d),var(--amber));
}
.card-top{
  display:flex;align-items:center;gap:10px;
  padding:18px 24px 16px;border-bottom:1px solid var(--border);
}
.card-top-icon{
  width:34px;height:34px;
  background:rgba(208,128,32,.1);
  border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.card-top-icon svg{ width:17px;height:17px;fill:none;stroke:var(--amber);stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
.card-top-title{ font-size:14px;font-weight:700;color:var(--text); }

/* plan name badge in header */
.editing-badge{
  margin-left:auto;
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:8px;
  background:rgba(208,128,32,.08);border:1px solid rgba(208,128,32,.2);
  font-size:11.5px;font-weight:700;color:var(--amber);
}

.form-body{ padding:24px 28px 28px; }
.field-group{ display:flex;flex-direction:column;gap:18px; }
.field-wrap{ display:flex;flex-direction:column;gap:6px; }
.field-label{ display:block;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.5px; }
.field-input{
  width:100%;background:var(--bg);border:1.5px solid var(--border);
  border-radius:9px;padding:10px 13px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;
  transition:border-color .2s var(--ease),box-shadow .2s var(--ease);
}
.field-input::placeholder{ color:var(--text3); }
.field-input:focus{ border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);background:var(--white); }
textarea.field-input{ resize:vertical;min-height:90px; }
.field-select{
  width:100%;background:var(--bg);border:1.5px solid var(--border);
  border-radius:9px;padding:10px 36px 10px 13px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA8C4' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 12px center;
  transition:border-color .2s,box-shadow .2s;
}
.field-select:focus{ border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);background-color:var(--white); }

.field-row{ display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px; }
@media(max-width:640px){ .field-row{ grid-template-columns:1fr; } }

.form-divider{ height:1px;background:var(--border);margin:4px 0; }

.form-actions{ display:flex;align-items:center;gap:10px;padding-top:6px; }

.btn-update{
  display:inline-flex;align-items:center;gap:6px;
  padding:11px 24px;border-radius:9px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:13.5px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,var(--amber-d),var(--amber));
  box-shadow:0 3px 12px rgba(208,128,32,.28);
  transition:opacity .2s,transform .15s;
}
.btn-update:hover{ opacity:.9;transform:translateY(-1px); }
.btn-update svg{ width:14px;height:14px;fill:none;stroke:#fff;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round; }

.btn-back{
  display:inline-flex;align-items:center;gap:6px;
  padding:11px 20px;border-radius:9px;
  border:1.5px solid var(--border);background:var(--neutral-bg);
  font-family:'Inter',sans-serif;font-size:13.5px;font-weight:700;
  color:var(--text2);text-decoration:none;
  transition:background .15s,border-color .15s;
}
.btn-back:hover{ background:#E8EDF2;border-color:#C0CDD8;color:var(--text); }
.btn-back svg{ width:14px;height:14px;fill:none;stroke:var(--text2);stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

@media(max-width:640px){ .form-page{ padding:16px 14px 32px; } }
</style>

<div class="form-page">

  <div class="breadcrumb-row">
    <a href="{{ route('admin.patient-plans.index') }}">Patient Plans</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-cur">Edit Plan</span>
  </div>

  <div class="page-eyebrow">Admin Panel</div>
  <div class="page-title">Edit <span>Patient Plan</span></div>

  <div class="panel">

    <div class="card-top">
      <div class="card-top-icon">
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </div>
      <div class="card-top-title">Edit Plan Details</div>
      <div class="editing-badge">{{ $plan->name }}</div>
    </div>

    <div class="form-body">
      <form action="{{ route('admin.patient-plans.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field-group">

          <div class="field-wrap">
            <label class="field-label">Plan Name</label>
            <input type="text" name="name" value="{{ $plan->name }}" class="field-input" required>
          </div>

          <div class="field-wrap">
            <label class="field-label">Description</label>
            <textarea name="description" class="field-input">{{ $plan->description }}</textarea>
          </div>

          <div class="form-divider"></div>

          <div class="field-row">

            {{-- <div class="field-wrap">
              <label class="field-label">Price</label>
              <input type="number" step="0.01" name="price" value="{{ $plan->price }}" class="field-input" required>
            </div> --}}

            <div class="field-wrap">
                <label class="field-label">Status</label>
                <select name="status" class="field-select">
                    <option value="active" {{ $plan->status == 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ $plan->status == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="field-wrap">
              <label class="field-label">Total Appointments</label>
              <input type="number" name="total_appointments" value="{{ $plan->total_appointments }}" class="field-input" required>
            </div>

            <div class="field-wrap">
              <label class="field-label">Duration</label>
              <select name="duration" class="field-select">
                <option value="weekly"     {{ $plan->duration == 'weekly'     ? 'selected' : '' }}>Weekly</option>
                <option value="monthly"    {{ $plan->duration == 'monthly'    ? 'selected' : '' }}>Monthly</option>
                <option value="quarterly"  {{ $plan->duration == 'quarterly'  ? 'selected' : '' }}>Quarterly</option>
                <option value="half_yearly"{{ $plan->duration == 'half_yearly'? 'selected' : '' }}>Half Yearly</option>
                <option value="yearly"     {{ $plan->duration == 'yearly'     ? 'selected' : '' }}>Yearly</option>
              </select>
            </div>

          </div>

          <div class="field-row" style="grid-template-columns: 1fr 1fr;">

            <div class="field-wrap">
                <label class="field-label">Package Discount (%)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    id="discount_percentage"
                    name="discount_percentage"
                    value="{{ old('discount_percentage', $plan->discount_percentage ?? 0) }}"
                    class="field-input"
                    placeholder="e.g. 10">
                <div class="form-hint" style="font-size:11.5px;color:var(--text3);margin-top:3px;">
                  Discount percentage deducted from the total package price at checkout.
                </div>
            </div>

            <!-- Hidden price fallback for schema compatibility -->
            <input type="hidden" name="price" id="price" value="{{ $plan->price ?? 0 }}">
            <input type="hidden" name="original_price" id="original_price" value="{{ $plan->original_price ?? 0 }}">

          </div>

          <!-- Dynamic Pricing Explanation Card -->
          <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 16px; margin-top: 4px;">
            <div style="font-size: 13px; font-weight: 700; color: #166534; display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
              </svg>
              How Package Pricing Works
            </div>
            <div style="font-size: 12px; color: #15803d; line-height: 1.5;">
              Package prices are calculated dynamically when a patient selects a doctor:
              <br>
              <strong>Formula:</strong> <code>Package Price = (Doctor Fee + Admin Fee) × Appointments - Discount %</code>
            </div>
            <div style="margin-top: 10px; padding: 10px 12px; background: #fff; border: 1px solid #dcfce7; border-radius: 8px; font-size: 12px;">
              <div style="font-weight: 700; color: #14532d; margin-bottom: 4px;">Sample Calculation (<span id="sampleApptsText">{{ $plan->total_appointments }} sessions</span>):</div>
              <div style="color: #475569;">Doctor Fee (₹500) + Admin Fee (₹100) = <strong>₹600 per session</strong></div>
              <div style="color: #475569; margin-top: 2px;">Base Package Price: <span id="sampleBasePrice">₹3,000</span></div>
              <div style="color: #d97706; margin-top: 2px;">Package Discount (<span id="sampleDiscPct">0%</span>): <span id="sampleDiscAmt">-₹0</span></div>
              <div style="margin-top: 4px; padding-top: 4px; border-top: 1px dashed #bbf7d0; color: #059669; font-weight: 800; font-size: 13.5px;">
                Customer Pays: <span id="sampleFinalPrice">₹3,000</span>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-update">
              <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              Update Plan
            </button>
            <a href="{{ route('admin.patient-plans.index') }}" class="btn-back">
              <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
              Back
            </a>
          </div>

        </div>
      </form>
    </div>

  </div>
</div>

<script>
function updateSamplePreview() {
    const apptsInput = document.querySelector('input[name="total_appointments"]');
    const discInput  = document.getElementById('discount_percentage');

    const appts = parseInt(apptsInput ? apptsInput.value : 0) || 1;
    let discPct = parseFloat(discInput ? discInput.value : 0) || 0;
    if (discPct < 0) discPct = 0;
    if (discPct > 100) discPct = 100;

    const sampleRate = 600; // e.g. 500 doctor fee + 100 admin fee
    const baseTotal  = sampleRate * appts;
    const discAmount = Math.round((baseTotal * discPct) / 100);
    const finalPrice = baseTotal - discAmount;

    document.getElementById('sampleApptsText').textContent = appts + ' ' + (appts === 1 ? 'session' : 'sessions');
    document.getElementById('sampleBasePrice').textContent = '₹' + baseTotal.toLocaleString('en-IN');
    document.getElementById('sampleDiscPct').textContent   = discPct + '%';
    document.getElementById('sampleDiscAmt').textContent   = '-₹' + discAmount.toLocaleString('en-IN');
    document.getElementById('sampleFinalPrice').textContent= '₹' + finalPrice.toLocaleString('en-IN');
}

const apptsElem = document.querySelector('input[name="total_appointments"]');
const discElem  = document.getElementById('discount_percentage');

if (apptsElem) apptsElem.addEventListener('input', updateSamplePreview);
if (discElem)  discElem.addEventListener('input', updateSamplePreview);

updateSamplePreview();
</script>

@endsection