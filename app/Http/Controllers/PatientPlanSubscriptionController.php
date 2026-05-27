<?php

namespace App\Http\Controllers;

use App\Models\PatientPlanSubscription;
use Illuminate\Http\Request;

class PatientPlanSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = PatientPlanSubscription::with([
                'patient',
                'plan'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.patient-plan-subscriptions.index',
            compact('subscriptions')
        );
    }
}