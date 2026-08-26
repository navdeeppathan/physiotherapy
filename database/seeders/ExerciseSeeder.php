<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        // Get specialization IDs by name
        $specIds = DB::table('specializations')->pluck('id', 'name')->toArray();

        $backId     = $specIds['Lower Back Pain']       ?? $specIds['Back Pain'] ?? null;
        $cervicalId = $specIds['Cervical Pain']         ?? $specIds['Neck Pain'] ?? null;
        $kneeId     = $specIds['Knee Pain / OA Knee']   ?? $specIds['Knee Pain'] ?? null;
        $shoulderId = $specIds['Shoulder Pain']         ?? null;
        $strokeId   = $specIds['Stroke / Hemiplegia']  ?? null;
        $ankleId    = $specIds['Ankle Sprain']          ?? null;

        $exercises = [
            // ── Lower Back Pain ──────────────────────────────────────
            ['name' => 'Pelvic Tilt',             'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Knee to Chest Stretch',   'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Cat Camel Stretch',       'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Bridging',                'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Bird Dog',                'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Lumbar Rotation Stretch', 'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Child Pose Stretch',      'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Hip Flexor Stretch',      'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 2, 'reps_default' => 30],

            // ── Cervical Pain ────────────────────────────────────────
            ['name' => 'Chin Tucks',                'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Neck Side Stretch',         'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Neck Rotation Stretch',     'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Shoulder Shrugs',           'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Levator Scapulae Stretch',  'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10],

            // ── Knee Pain / OA Knee ──────────────────────────────────
            ['name' => 'Quad Sets',               'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'SLR (Straight Leg Raise)','category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Short Arc Quads',         'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Wall Slides',             'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Hamstring Stretch',       'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 30],
            ['name' => 'Seated Knee Flexion',     'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Step Ups',                'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10],

            // ── Shoulder Pain ────────────────────────────────────────
            ['name' => 'Pendulum Exercise',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Shoulder Flexion',         'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'External Rotation',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Doorway Stretch',          'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Scapular Squeezes',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10],

            // ── Stroke / Hemiplegia ──────────────────────────────────
            ['name' => 'Ankle Pumps',             'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Hand Finger Exercises',   'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Assisted Hip Flexion',    'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Seated Balance Exercises','category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10],

            // ── Ankle Sprain ─────────────────────────────────────────
            ['name' => 'Ankle Alphabet',          'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 1],
            ['name' => 'Calf Raises',             'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 10],
            ['name' => 'Single Leg Balance',      'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 30],
            ['name' => 'Resistance Band Eversion','category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 10],

            // ── General (no specialization) ──────────────────────────
            ['name' => 'Deep Breathing',          'category' => 'general',  'specialization_id' => null,       'sets_default' => 1, 'reps_default' => 10],
            ['name' => 'Walking Programme',       'category' => 'general',  'specialization_id' => null,       'sets_default' => 1, 'reps_default' => 1],
        ];

        foreach ($exercises as $ex) {
            DB::table('exercises')->insertOrIgnore([
                'name'              => $ex['name'],
                'category'          => $ex['category'],
                'specialization_id' => $ex['specialization_id'],
                'sets_default'      => $ex['sets_default'],
                'reps_default'      => $ex['reps_default'],
                'status'            => 'active',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        $this->command->info('✅ Exercises seeded successfully: ' . count($exercises) . ' exercises added.');
    }
}
