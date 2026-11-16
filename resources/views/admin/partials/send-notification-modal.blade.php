<!-- ── SEND PUSH NOTIFICATION MODAL ── -->
<div class="modal fade" id="adminNotificationModal" tabindex="-1" aria-labelledby="adminNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); font-family: 'Inter', 'Poppins', sans-serif;">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #FAF5FF; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title" id="adminNotificationModalLabel" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Send Firebase Push Notification</h5>
                        <div style="font-size: 12px; color: #64748B; margin-top: 2px;">Broadcast real-time mobile alert to devices</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 12px;"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 22px 24px;">
                <form id="adminNotificationForm">
                    @csrf
                    <input type="hidden" name="user_id" id="notify_user_id" value="">

                    <!-- Target Audience -->
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                            Target Audience <span style="color: #DC2626;">*</span>
                        </label>
                        <select name="target" id="notify_target" class="form-select" style="height: 42px; border-radius: 9px; border: 1px solid #CBD5E1; font-size: 13.5px; font-weight: 500; color: #1E293B; background-color: #F8FAFC;">
                            <option value="all_doctors">👨‍⚕️ All Doctors</option>
                            <option value="all_patients">🧑‍🤝‍🧑 All Patients</option>
                            <option value="all_users">🌐 Everyone (All Doctors & Patients)</option>
                            <option value="specific_user">🎯 Specific User</option>
                        </select>
                    </div>

                    <!-- Specific User Indicator Banner (Hidden by default, shown when targeting 1 user) -->
                    <div id="notifySpecificUserBanner" style="display: none; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 16px;">👤</span>
                            <div>
                                <div id="notifySpecificUserName" style="font-size: 13px; font-weight: 700; color: #1E40AF;">Dr. Jane Smith</div>
                                <div id="notifySpecificUserRole" style="font-size: 11px; color: #3B82F6;">Doctor (ID #12)</div>
                            </div>
                        </div>
                        <button type="button" id="notifyClearSpecificUser" style="background: none; border: none; font-size: 11.5px; color: #2563EB; font-weight: 600; cursor: pointer; text-decoration: underline;">
                            Change Audience
                        </button>
                    </div>

                    <!-- Notification Title -->
                    <div class="mb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label class="form-label" style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 0;">
                                Notification Title <span style="color: #DC2626;">*</span>
                            </label>
                            <span id="notifyTitleCount" style="font-size: 11px; color: #94A3B8;">0/120</span>
                        </div>
                        <input
                            type="text"
                            name="title"
                            id="notify_title"
                            class="form-control"
                            maxlength="120"
                            placeholder="e.g. Schedule Update / Important Notice"
                            required
                            style="height: 42px; border-radius: 9px; border: 1px solid #CBD5E1; font-size: 13.5px; color: #0F172A;"
                        >
                    </div>

                    <!-- Notification Message / Body -->
                    <div class="mb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label class="form-label" style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 0;">
                                Message Body <span style="color: #DC2626;">*</span>
                            </label>
                            <span id="notifyBodyCount" style="font-size: 11px; color: #94A3B8;">0/500</span>
                        </div>
                        <textarea
                            name="body"
                            id="notify_body"
                            class="form-control"
                            rows="3"
                            maxlength="500"
                            placeholder="Type the message to be displayed in the mobile notification tray…"
                            required
                            style="border-radius: 9px; border: 1px solid #CBD5E1; font-size: 13.5px; color: #0F172A; resize: vertical;"
                        ></textarea>
                    </div>

                    <!-- Notification Category / Deep Link -->
                    <div class="mb-1">
                        <label class="form-label" style="font-size: 12px; font-weight: 600; color: #64748B; margin-bottom: 5px; display: block;">
                            Notification Type (Optional Tag)
                        </label>
                        <select name="type" id="notify_type" class="form-select form-select-sm" style="border-radius: 8px; border: 1px solid #E2E8F0; font-size: 12.5px; color: #475569;">
                            <option value="admin_broadcast">📢 General Broadcast</option>
                            <option value="appointment_alert">🩺 Appointment Notice</option>
                            <option value="slots_alert">📅 Slots & Availability</option>
                            <option value="profile_reminder">👤 Profile Reminder</option>
                        </select>
                    </div>

                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="padding: 14px 24px; border-top: 1px solid #F1F5F9; background: #F8FAFC; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13px; font-weight: 500; color: #64748B; border: 1px solid #E2E8F0; padding: 7px 14px;">
                    Cancel
                </button>
                <button type="button" id="btnSubmitAdminNotification" class="btn" style="background: linear-gradient(135deg, #4F46E5 0%, #2563EB 100%); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 8px 20px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                    <span id="notifySpinner" class="spinner-border spinner-border-sm" style="display: none; width: 13px; height: 13px; border-width: 2px;"></span>
                    <svg id="notifySendIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    <span id="notifyBtnText">Send Notification</span>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifyModalEl = document.getElementById('adminNotificationModal');
    if (!notifyModalEl) return;

    let notifyModal = null;
    try {
        notifyModal = new bootstrap.Modal(notifyModalEl);
    } catch (e) {
        // Fallback if bootstrap is on window
        if (window.bootstrap && window.bootstrap.Modal) {
            notifyModal = new window.bootstrap.Modal(notifyModalEl);
        }
    }

    const notifyForm         = document.getElementById('adminNotificationForm');
    const targetSelect       = document.getElementById('notify_target');
    const userIdInput        = document.getElementById('notify_user_id');
    const specificUserBanner = document.getElementById('notifySpecificUserBanner');
    const specificUserName   = document.getElementById('notifySpecificUserName');
    const specificUserRole   = document.getElementById('notifySpecificUserRole');
    const clearSpecificUser  = document.getElementById('notifyClearSpecificUser');
    const titleInput         = document.getElementById('notify_title');
    const bodyInput          = document.getElementById('notify_body');
    const titleCount         = document.getElementById('notifyTitleCount');
    const bodyCount          = document.getElementById('notifyBodyCount');
    const submitBtn          = document.getElementById('btnSubmitAdminNotification');
    const btnText            = document.getElementById('notifyBtnText');
    const spinner            = document.getElementById('notifySpinner');
    const sendIcon           = document.getElementById('notifySendIcon');

    // Character counter listeners
    if (titleInput && titleCount) {
        titleInput.addEventListener('input', () => {
            titleCount.textContent = `${titleInput.value.length}/120`;
        });
    }
    if (bodyInput && bodyCount) {
        bodyInput.addEventListener('input', () => {
            bodyCount.textContent = `${bodyInput.value.length}/500`;
        });
    }

    // Toggle specific user banner on target change
    if (targetSelect) {
        targetSelect.addEventListener('change', function () {
            if (this.value !== 'specific_user') {
                if (specificUserBanner) specificUserBanner.style.display = 'none';
                if (userIdInput) userIdInput.value = '';
            } else if (userIdInput && userIdInput.value) {
                if (specificUserBanner) specificUserBanner.style.display = 'flex';
            }
        });
    }

    if (clearSpecificUser) {
        clearSpecificUser.addEventListener('click', function () {
            if (userIdInput) userIdInput.value = '';
            if (specificUserBanner) specificUserBanner.style.display = 'none';
            if (targetSelect) targetSelect.value = 'all_doctors';
        });
    }

    // ── 1. Open Notification Modal from Header Broadcast Button ──
    document.querySelectorAll('.btn-open-notify-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const defaultTarget = this.dataset.target || 'all_doctors';
            if (notifyForm) notifyForm.reset();
            if (titleCount) titleCount.textContent = '0/120';
            if (bodyCount) bodyCount.textContent = '0/500';
            if (userIdInput) userIdInput.value = '';
            if (specificUserBanner) specificUserBanner.style.display = 'none';
            if (targetSelect) targetSelect.value = defaultTarget;

            if (notifyModal) notifyModal.show();
        });
    });

    // ── 2. Open Notification Modal for Specific Row User ──
    document.querySelectorAll('.btn-notify-user').forEach(btn => {
        btn.addEventListener('click', function () {
            const userId   = this.dataset.id;
            const userName = this.dataset.name || 'User';
            const userRole = this.dataset.role || 'User';

            if (notifyForm) notifyForm.reset();
            if (titleCount) titleCount.textContent = '0/120';
            if (bodyCount) bodyCount.textContent = '0/500';

            if (userIdInput) userIdInput.value = userId;
            if (targetSelect) targetSelect.value = 'specific_user';

            if (specificUserName) specificUserName.textContent = userName;
            if (specificUserRole) specificUserRole.textContent = `${userRole} (ID #${userId})`;
            if (specificUserBanner) specificUserBanner.style.display = 'flex';

            if (notifyModal) notifyModal.show();
        });
    });

    // ── 3. Submit Push Notification ──
    if (submitBtn) {
        submitBtn.addEventListener('click', function () {
            const title  = titleInput ? titleInput.value.trim() : '';
            const body   = bodyInput ? bodyInput.value.trim() : '';
            const target = targetSelect ? targetSelect.value : 'all_doctors';
            const userId = userIdInput ? userIdInput.value : '';

            if (!title) {
                if (titleInput) titleInput.focus();
                Swal.fire({ icon: 'warning', title: 'Title Required', text: 'Please enter a notification title.', customClass: { popup: 'swal-inter' } });
                return;
            }

            if (!body) {
                if (bodyInput) bodyInput.focus();
                Swal.fire({ icon: 'warning', title: 'Message Required', text: 'Please enter a notification message.', customClass: { popup: 'swal-inter' } });
                return;
            }

            if (target === 'specific_user' && !userId) {
                Swal.fire({ icon: 'warning', title: 'Target Missing', text: 'Please select a specific user or change audience to All Doctors/Patients.', customClass: { popup: 'swal-inter' } });
                return;
            }

            // Button loading state
            submitBtn.disabled = true;
            if (spinner) spinner.style.display = 'inline-block';
            if (sendIcon) sendIcon.style.display = 'none';
            if (btnText) btnText.textContent = 'Sending...';

            const payload = {
                target:  target,
                user_id: userId,
                title:   title,
                body:    body,
                type:    document.getElementById('notify_type') ? document.getElementById('notify_type').value : 'admin_broadcast'
            };

            fetch("{{ route('admin.notifications.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept':       'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                if (spinner) spinner.style.display = 'none';
                if (sendIcon) sendIcon.style.display = 'inline-block';
                if (btnText) btnText.textContent = 'Send Notification';

                if (data.success) {
                    if (notifyModal) notifyModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Dispatched!',
                        text: data.message || 'Notification sent successfully.',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-inter' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sending Failed',
                        text: data.message || 'Could not send notification. Please check Firebase credentials.',
                        confirmButtonColor: '#2563EB',
                        customClass: { popup: 'swal-inter' }
                    });
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                if (spinner) spinner.style.display = 'none';
                if (sendIcon) sendIcon.style.display = 'inline-block';
                if (btnText) btnText.textContent = 'Send Notification';

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong while connecting to the server. Please try again.',
                    confirmButtonColor: '#2563EB',
                    customClass: { popup: 'swal-inter' }
                });
            });
        });
    }
});
</script>
