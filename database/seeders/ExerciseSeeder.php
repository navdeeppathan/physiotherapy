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
            ['name' => 'Pelvic Tilt',             'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Lie on your back with knees bent and feet flat. Gently flatten your lower back against the floor by tightening your abdominal muscles.'],
            ['name' => 'Knee to Chest Stretch',   'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '20 sec hold', 'description' => 'Lie on your back, slowly pull one knee toward your chest until a gentle stretch is felt in the lower back and glutes.'],
            ['name' => 'Cat Camel Stretch',       'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'On hands and knees, slowly arch your back upward like a cat, then gently lower your belly toward the floor.'],
            ['name' => 'Bridging',                'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Lie on your back with knees bent. Tighten abdominal and gluteal muscles and lift your hips until your body forms a straight line.'],
            ['name' => 'Bird Dog',                'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'On hands and knees, extend your right arm forward and left leg backward simultaneously. Keep spine neutral.'],
            ['name' => 'Lumbar Rotation Stretch', 'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '15 sec hold', 'description' => 'Lie on your back with knees bent. Slowly lower both knees to one side until a gentle stretch is felt in the lower back.'],
            ['name' => 'Child Pose Stretch',      'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '30 sec hold', 'description' => 'Kneel on the floor, sit back on your heels and extend arms forward on the ground to lengthen the spine.'],
            ['name' => 'Hip Flexor Stretch',      'category' => 'back',     'specialization_id' => $backId,     'sets_default' => 2, 'reps_default' => 30, 'duration_default' => '30 sec hold', 'description' => 'Kneel on one knee with the opposite foot forward. Shift weight forward until you feel a stretch in the front of your hip.'],

            // ── Cervical Pain ────────────────────────────────────────
            ['name' => 'Chin Tucks',                'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Sit upright, look straight ahead, and gently draw your chin straight back toward your neck as if making a double chin.'],
            ['name' => 'Neck Side Stretch',         'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '20 sec hold', 'description' => 'Gently tilt your head to the side, bringing your ear toward your shoulder until a stretch is felt along the side of the neck.'],
            ['name' => 'Neck Rotation Stretch',     'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '10 sec hold', 'description' => 'Turn your head slowly to one side until you feel a comfortable stretch along the neck muscles.'],
            ['name' => 'Shoulder Shrugs',           'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '3 sec hold',  'description' => 'Lift your shoulders straight up toward your ears, hold briefly, then release down and roll shoulders backward.'],
            ['name' => 'Levator Scapulae Stretch',  'category' => 'cervical', 'specialization_id' => $cervicalId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '20 sec hold', 'description' => 'Turn head 45 degrees to the side and look down toward your armpit, using gentle hand pressure on the crown.'],

            // ── Knee Pain / OA Knee ──────────────────────────────────
            ['name' => 'Quad Sets',               'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Sit with legs straight out. Tighten the thigh muscle (quadriceps) by pressing the back of your knee flat into the bed.'],
            ['name' => 'SLR (Straight Leg Raise)','category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Lie on your back with one knee bent and the other straight. Tighten thigh muscle and lift the straight leg about 12 inches.'],
            ['name' => 'Short Arc Quads',         'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Lie with a rolled towel under your knee. Straighten your knee by lifting your foot up toward the ceiling.'],
            ['name' => 'Wall Slides',             'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Stand with back against a wall, slide down into a shallow squat position (max 45 degrees) and hold before returning.'],
            ['name' => 'Hamstring Stretch',       'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 30, 'duration_default' => '30 sec hold', 'description' => 'Sit on edge of a chair with one leg extended. Hinge forward at the hips keeping back straight until back of thigh stretches.'],
            ['name' => 'Seated Knee Flexion',     'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Sit on a chair, slowly bend your knee sliding your foot back under the seat as far as comfortable.'],
            ['name' => 'Step Ups',                'category' => 'knee',     'specialization_id' => $kneeId,     'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '10 reps each', 'description' => 'Step onto a 6-inch step with the affected leg, straighten knee to stand up, then step back down under control.'],

            // ── Shoulder Pain ────────────────────────────────────────
            ['name' => 'Pendulum Exercise',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '1 min',       'description' => 'Lean forward supporting body with unaffected arm. Let the affected arm dangle and gently swing in small circles.'],
            ['name' => 'Shoulder Flexion',         'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Raise your arm straight forward and overhead as far as comfortable without arching your back.'],
            ['name' => 'External Rotation',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '3 sec hold',  'description' => 'Keep elbow bent 90 degrees tucked at your side. Rotate your forearm outward away from your body.'],
            ['name' => 'Doorway Stretch',          'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '20 sec hold', 'description' => 'Stand in a doorway with forearms on door frame at 90 degrees. Step forward gently until chest and front shoulders stretch.'],
            ['name' => 'Scapular Squeezes',        'category' => 'shoulder', 'specialization_id' => $shoulderId, 'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Sit or stand tall. Squeeze your shoulder blades together toward your spine without lifting shoulders.'],

            // ── Stroke / Hemiplegia ──────────────────────────────────
            ['name' => 'Ankle Pumps',             'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '10 reps',     'description' => 'Point your toes down away from you, then pull toes upward toward your shin to promote circulation and mobility.'],
            ['name' => 'Hand Finger Exercises',   'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '10 reps',     'description' => 'Open fingers wide, make a gentle fist, and touch each fingertip to the thumb sequentially to rebuild fine motor skills.'],
            ['name' => 'Assisted Hip Flexion',    'category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '5 sec hold',  'description' => 'Lie on your back, gently assist lifting your affected knee toward your chest using your hands or a strap.'],
            ['name' => 'Seated Balance Exercises','category' => 'stroke',   'specialization_id' => $strokeId,  'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '30 sec',      'description' => 'Sit on a stable chair without leaning on backrest. Reach arms in different directions while maintaining upright core balance.'],

            // ── Ankle Sprain ─────────────────────────────────────────
            ['name' => 'Ankle Alphabet',          'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 1,  'duration_default' => 'Full A-Z',     'description' => 'Trace the letters of the alphabet in the air with your big toe, moving only your ankle joint.'],
            ['name' => 'Calf Raises',             'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '3 sec hold',  'description' => 'Stand tall holding a stable surface for balance. Raise up onto your toes, pause briefly at the top, then lower slowly.'],
            ['name' => 'Single Leg Balance',      'category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 30, 'duration_default' => '30 sec hold', 'description' => 'Stand on the affected foot with knee slightly soft. Maintain balance for 30 seconds with arms across chest.'],
            ['name' => 'Resistance Band Eversion','category' => 'ankle',    'specialization_id' => $ankleId,   'sets_default' => 3, 'reps_default' => 10, 'duration_default' => '3 sec hold',  'description' => 'Loop a resistance band around the outer foot. Turn your foot outward against band resistance to strengthen ankle stabilizers.'],

            // ── General (no specialization) ──────────────────────────
            ['name' => 'Deep Breathing',          'category' => 'general',  'specialization_id' => null,       'sets_default' => 1, 'reps_default' => 10, 'duration_default' => '5 min',       'description' => 'Inhale deeply through your nose expanding your diaphragm, hold for 3 seconds, and exhale slowly through pursed lips.'],
            ['name' => 'Walking Programme',       'category' => 'general',  'specialization_id' => null,       'sets_default' => 1, 'reps_default' => 1,  'duration_default' => '20 min walk',  'description' => 'Continuous brisk walking at a comfortable pace on a flat surface to build general endurance and functional stamina.'],
        ];

        foreach ($exercises as $ex) {
            DB::table('exercises')->updateOrInsert(
                ['name' => $ex['name']],
                [
                    'category'          => $ex['category'],
                    'specialization_id' => $ex['specialization_id'],
                    'sets_default'      => $ex['sets_default'],
                    'reps_default'      => $ex['reps_default'],
                    'duration_default'  => $ex['duration_default'],
                    'description'       => $ex['description'],
                    'status'            => 'active',
                    'updated_at'        => now(),
                ]
            );
        }
    }
}
