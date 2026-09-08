<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\PatientPlanSubscription;

class ResetAppointmentStatus extends Command
{
    protected $signature = 'appointment:reset {id} {status=confirmed}';
    protected $description = 'Reset an appointment status and sync subscription counts';

    public function handle()
    {
        $id     = (int) $this->argument('id');
        $status = (string) $this->argument('status');

        $appointment = Appointment::find($id);
        if (!$appointment) {
            $this->error("Appointment with ID {$id} not found.");
            return 1;
        }

        $prevStatus = $appointment->status;
        $appointment->update(['status' => $status]);

        $this->info("Appointment #{$id} status updated from '{$prevStatus}' to '{$status}'.");

        if ($appointment->patient_plan_subscription_id) {
            $sub = PatientPlanSubscription::find($appointment->patient_plan_subscription_id);
            if ($sub) {
                $completedCount = Appointment::where('patient_plan_subscription_id', $sub->id)
                    ->where('status', 'completed')
                    ->count();

                $totalAppts = optional($sub->plan)->total_appointments ?? ($sub->used_appointments + $sub->remaining_appointments);
                $sub->update([
                    'used_appointments'      => $completedCount,
                    'remaining_appointments' => max(0, $totalAppts - $completedCount),
                ]);

                $this->info("Subscription #{$sub->id} synced: used_appointments={$completedCount}, remaining=" . max(0, $totalAppts - $completedCount));
            }
        }

        return 0;
    }
}
