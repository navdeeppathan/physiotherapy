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
  --green:      #16A96A;
  --green-bg:   #E8F8F2;
  --green-d:    #0E7A4D;
  --rose:       #E55A6B;
  --rose-bg:    #FDEEF0;
  --rose-d:     #C13050;
  --amber:      #D08020;
  --amber-bg:   #FEF5E7;
  --amber-d:    #9A5C10;
  --neutral-bg: #F2F5F8;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

*{ box-sizing:border-box; }

.spec-page{
  padding:28px 28px 48px;
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
}

/* ── PAGE HEAD ── */
.page-eyebrow{
  font-size:11px;font-weight:700;color:var(--blue);
  text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;
}
.page-title{
  font-size:22px;font-weight:700;color:var(--text);letter-spacing:-.3px;
  margin-bottom:22px;
}
.page-title span{ font-weight:300;color:var(--text2); }

/* ── SHARED PANEL ── */
.panel{
  background:var(--white);border:1px solid var(--border);
  border-radius:16px;overflow:hidden;
  box-shadow:0 2px 8px rgba(45,125,210,.05),0 10px 32px rgba(26,91,168,.07);
  position:relative;margin-bottom:20px;
}
.panel::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--blue-d),var(--blue-mid));
}
.panel-head{
  display:flex;align-items:center;gap:10px;
  padding:18px 22px 16px;border-bottom:1px solid var(--border);
}
.panel-icon{
  width:34px;height:34px;background:var(--blue-l);
  border-radius:9px;display:flex;align-items:center;
  justify-content:center;flex-shrink:0;
}
.panel-icon svg{
  width:17px;height:17px;fill:none;stroke:var(--blue);
  stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;
}
.panel-title{ font-size:14px;font-weight:700;color:var(--text); }
.panel-body{ padding:20px 22px; }

/* ── SUCCESS ALERT ── */
.alert-success-bar{
  display:flex;align-items:center;gap:10px;
  background:var(--green-bg);border:1px solid rgba(22,169,106,.2);
  border-radius:10px;padding:11px 16px;margin-bottom:20px;
}
.alert-success-bar svg{
  width:18px;height:18px;flex-shrink:0;fill:none;
  stroke:var(--green);stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}
.alert-success-bar span{
  font-size:13px;font-weight:600;color:var(--green);
}

/* ── ADD FORM ── */
.add-grid{
  display:grid;
  grid-template-columns:1fr 1fr 2fr auto;
  gap:12px;
  align-start:start;
}
@media(max-width:900px){
  .add-grid{ grid-template-columns:1fr 1fr; }
}
@media(max-width:600px){
  .add-grid{ grid-template-columns:1fr; }
}

.field-label{
  display:block;font-size:10.5px;font-weight:700;color:var(--text3);
  text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;
}
.field-input{
  width:100%;background:var(--bg);border:1.5px solid var(--border);
  border-radius:9px;padding:9px 12px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;
  transition:border-color .2s var(--ease),box-shadow .2s var(--ease);
}
.field-input::placeholder{ color:var(--text3); }
.field-input:focus{
  border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);
  background:var(--white);
}
textarea.field-input{ resize:vertical;min-height:72px; }

/* file input */
.file-wrap{
  position:relative;
}
.file-wrap input[type="file"]{
  width:100%;background:var(--bg);border:1.5px dashed var(--border);
  border-radius:9px;padding:8px 12px;
  font-family:'Inter',sans-serif;font-size:12px;font-weight:500;
  color:var(--text2);outline:none;cursor:pointer;
  transition:border-color .2s;
}
.file-wrap input[type="file"]:hover{
  border-color:var(--blue);
}

.btn-add{
  display:inline-flex;align-items:center;justify-content:center;gap:6px;
  padding:10px 22px;border-radius:9px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,var(--blue-d),var(--blue));
  box-shadow:0 3px 10px rgba(45,125,210,.25);
  transition:opacity .2s,transform .15s,box-shadow .2s;
  white-space:nowrap;align-self:flex-end;height:40px;
}
.btn-add:hover{ opacity:.9;transform:translateY(-1px);box-shadow:0 5px 16px rgba(45,125,210,.35); }
.btn-add svg{
  width:14px;height:14px;fill:none;stroke:#fff;
  stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round;
}

/* ── LIST TABLE ── */
.table-wrap{ overflow-x:auto; }
table.spec-table{ width:100%;border-collapse:collapse; }
.spec-table thead tr{
  background:#F4F8FE;border-bottom:1.5px solid var(--border);
}
.spec-table thead th{
  padding:10px 16px;font-size:11px;font-weight:700;
  text-transform:uppercase;letter-spacing:.55px;
  color:var(--text3);white-space:nowrap;text-align:left;
}
.spec-table thead th:first-child{ width:48px;text-align:center; }

/* body rows alternate: view row + edit row */
.spec-table tbody tr.view-row{
  border-bottom:none;
  transition:background .15s;
}
.spec-table tbody tr.view-row:hover{ background:#F7FAFF; }

.spec-table tbody tr.edit-row{
  background:#FAFCFF;
  border-bottom:1.5px solid var(--border);
  display:none; /* toggled by JS */
}
.spec-table tbody tr.edit-row.open{
  display:table-row;
}

.spec-table tbody td{
  padding:13px 16px;font-size:13px;font-weight:500;
  color:var(--text);vertical-align:middle;
}
.spec-table tbody td:first-child{
  text-align:center;font-size:11.5px;font-weight:700;color:var(--text3);
}

/* icon cell */
.spec-icon-img{
  width:48px;height:48px;object-fit:cover;
  border-radius:10px;border:1.5px solid var(--border);
}
.spec-icon-placeholder{
  width:48px;height:48px;background:var(--neutral-bg);
  border-radius:10px;border:1.5px dashed var(--border);
  display:flex;align-items:center;justify-content:center;
}
.spec-icon-placeholder svg{
  width:20px;height:20px;fill:none;stroke:var(--text3);
  stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;
}

.cell-name{ font-weight:700;color:var(--text);font-size:13.5px; }
.cell-desc{
  font-size:12.5px;font-weight:500;color:var(--text2);
  max-width:260px;
  display:-webkit-box;-webkit-line-clamp:2;
  -webkit-box-orient:vertical;overflow:hidden;
}

/* status badge */
.badge-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:20px;
  font-size:11px;font-weight:700;letter-spacing:.2px;
  border:1px solid transparent;
}
.badge-pill::before{
  content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;
}
.bp-active{
  background:var(--green-bg);color:var(--green);
  border-color:rgba(22,169,106,.2);
}
.bp-active::before{ background:var(--green); }
.bp-inactive{
  background:var(--neutral-bg);color:var(--text3);
  border-color:var(--border);
}
.bp-inactive::before{ background:var(--text3); }

/* action row buttons */
.action-btns{ display:flex;gap:6px;align-items:center; }

.btn-edit{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1.5px solid var(--border);
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:var(--blue);background:var(--blue-l);cursor:pointer;
  transition:background .15s,border-color .15s;
}
.btn-edit:hover{ background:#D4E8FA;border-color:var(--blue); }
.btn-edit svg{
  width:13px;height:13px;fill:none;stroke:var(--blue);
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}

.btn-del{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1.5px solid rgba(229,90,107,.2);
  font-family:'Inter',sans-serif;font-size:12px;font-weight:700;
  color:var(--rose);background:var(--rose-bg);cursor:pointer;
  transition:background .15s,border-color .15s;
}
.btn-del:hover{ background:#FAD8DC;border-color:var(--rose); }
.btn-del svg{
  width:13px;height:13px;fill:none;stroke:var(--rose);
  stroke-width:2;stroke-linecap:round;stroke-linejoin:round;
}

/* ── EDIT ROW INNER ── */
.edit-inner{
  padding:16px 0 4px;
}
.edit-grid{
  display:grid;
  grid-template-columns:1fr 1fr 2fr 160px;
  gap:12px;
  align-items:start;
}
@media(max-width:900px){
  .edit-grid{ grid-template-columns:1fr 1fr; }
}

.edit-current-img{
  width:56px;height:56px;object-fit:cover;
  border-radius:9px;border:1.5px solid var(--border);
  margin-bottom:6px;display:block;
}

.field-select{
  width:100%;background:var(--bg);border:1.5px solid var(--border);
  border-radius:9px;padding:9px 32px 9px 12px;
  font-family:'Inter',sans-serif;font-size:13px;font-weight:500;
  color:var(--text);outline:none;appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA8C4' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 10px center;
  transition:border-color .2s,box-shadow .2s;
}
.field-select:focus{
  border-color:var(--blue);box-shadow:0 0 0 3px rgba(45,125,210,.10);
  background-color:var(--white);
}

.edit-actions{
  display:flex;flex-direction:column;gap:8px;margin-top:22px;
}

.btn-update{
  display:inline-flex;align-items:center;justify-content:center;gap:6px;
  padding:9px 16px;border-radius:8px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:12.5px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,var(--amber-d),var(--amber));
  box-shadow:0 3px 10px rgba(208,128,32,.25);
  transition:opacity .2s,transform .15s;width:100%;
}
.btn-update:hover{ opacity:.9;transform:translateY(-1px); }
.btn-update svg{
  width:13px;height:13px;fill:none;stroke:#fff;
  stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round;
}

.btn-cancel-edit{
  display:inline-flex;align-items:center;justify-content:center;
  padding:8px 16px;border-radius:8px;
  border:1.5px solid var(--border);background:var(--neutral-bg);
  font-family:'Inter',sans-serif;font-size:12.5px;font-weight:700;
  color:var(--text2);cursor:pointer;transition:background .15s;width:100%;
}
.btn-cancel-edit:hover{ background:#E8EDF2; }

@media(max-width:640px){
  .spec-page{ padding:16px 14px 32px; }
}
</style>

<div class="spec-page">

  <div class="page-eyebrow">Admin Panel</div>
  <div class="page-title">Specializations <span>Management</span></div>

  {{-- Success Alert --}}
  @if(session('success'))
    <div class="alert-success-bar">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- ── ADD FORM ── --}}
  <div class="panel">
    <div class="panel-head">
      <div class="panel-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      </div>
      <div class="panel-title">Add New Specialization</div>
    </div>
    <div class="panel-body">
      <form method="POST" action="{{ route('admin.specializations.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="add-grid">

          <div>
            <label class="field-label">Name</label>
            <input type="text" name="name" class="field-input" placeholder="e.g. Cardiology" required>
          </div>

          <div>
            <label class="field-label">Icon / Image</label>
            <div class="file-wrap">
              <input type="file" name="icon">
            </div>
          </div>

          <div>
            <label class="field-label">Description</label>
            <textarea name="description" class="field-input" placeholder="Brief description…" style="min-height:40px;"></textarea>
          </div>

          <div style="align-self:flex-end;">
            <button type="submit" class="btn-add" style="width:100%;">
              <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Add
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>

  {{-- ── LIST ── --}}
  <div class="panel">
    <div class="panel-head">
      <div class="panel-icon">
        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      </div>
      <div class="panel-title">All Specializations</div>
    </div>

    <div class="table-wrap">
      <table class="spec-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Icon</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          @foreach($specializations as $item)

          {{-- VIEW ROW --}}
          <tr class="view-row" id="view-{{ $item->id }}">

            <td>{{ $loop->iteration }}</td>

            <td>
              @if($item->icon)
                <img src="{{ asset('images/specializations/'.$item->icon) }}"
                     class="spec-icon-img" alt="{{ $item->name }}">
              @else
                <div class="spec-icon-placeholder">
                  <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
              @endif
            </td>

            <td><div class="cell-name">{{ $item->name }}</div></td>

            <td><div class="cell-desc">{{ $item->description }}</div></td>

            <td>
              @if($item->status == 'active')
                <span class="badge-pill bp-active">Active</span>
              @else
                <span class="badge-pill bp-inactive">{{ ucfirst($item->status) }}</span>
              @endif
            </td>

            <td>
              <div class="action-btns">

                <button type="button" class="btn-edit" onclick="toggleEdit({{ $item->id }})">
                  <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  Edit
                </button>

                <form method="POST"
                      action="{{ route('admin.specializations.destroy', $item->id) }}"
                      style="margin:0;"
                      onsubmit="return confirm('Delete this specialization?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-del">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete
                  </button>
                </form>

              </div>
            </td>

          </tr>

          {{-- EDIT ROW --}}
          <tr class="edit-row" id="edit-{{ $item->id }}">
            <td colspan="6" style="padding:0 16px 16px;">
              <div class="edit-inner">

                <form method="POST"
                      action="{{ route('admin.specializations.update', $item->id) }}"
                      enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="edit-grid">

                    <div>
                      <label class="field-label">Name</label>
                      <input type="text" name="name"
                             value="{{ $item->name }}"
                             class="field-input">
                    </div>

                    <div>
                      <label class="field-label">Icon / Image</label>
                      @if($item->icon)
                        <img src="{{ asset('images/specializations/'.$item->icon) }}"
                             class="edit-current-img" alt="current">
                      @endif
                      <div class="file-wrap">
                        <input type="file" name="icon">
                      </div>
                    </div>

                    <div>
                      <label class="field-label">Description</label>
                      <textarea name="description" class="field-input" style="min-height:60px;">{{ $item->description }}</textarea>
                    </div>

                    <div>
                      <label class="field-label">Status</label>
                      <select name="status" class="field-select" style="margin-bottom:0;">
                        <option value="active"   {{ $item->status=='active'   ? 'selected':'' }}>Active</option>
                        <option value="inactive" {{ $item->status=='inactive' ? 'selected':'' }}>Inactive</option>
                      </select>

                      <div class="edit-actions">
                        <button type="submit" class="btn-update">
                          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                          Save Changes
                        </button>
                        <button type="button" class="btn-cancel-edit" onclick="toggleEdit({{ $item->id }})">
                          Cancel
                        </button>
                      </div>
                    </div>

                  </div>

                </form>

              </div>
            </td>
          </tr>

          @endforeach

        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
function toggleEdit(id) {
  const editRow  = document.getElementById('edit-' + id);
  const viewRow  = document.getElementById('view-' + id);
  const isOpen   = editRow.classList.contains('open');

  // close all open edit rows first
  document.querySelectorAll('.edit-row.open').forEach(function(r){ r.classList.remove('open'); });
  document.querySelectorAll('.view-row').forEach(function(r){ r.style.background = ''; });

  if (!isOpen) {
    editRow.classList.add('open');
    viewRow.style.background = '#EEF4FB';
    editRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}
</script>

@endsection