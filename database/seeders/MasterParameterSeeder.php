<?php

namespace Database\Seeders;

use App\Models\MasterParameter;
use Illuminate\Database\Seeder;

class MasterParameterSeeder extends Seeder
{
    public function run(): void
    {
        $parameters = [
            [
                'key'        => 'pain_score',
                'label'      => 'Pain Score (0–10)',
                'unit'       => 'score',
                'icon_key'   => 'pain_score',
                'icon'       => 'assets/img/parameters/pain_score.svg',
                'sort_order' => 1,
            ],
            [
                'key'        => 'lumbar_flexion',
                'label'      => 'Lumbar Flexion (°)',
                'unit'       => '°',
                'icon_key'   => 'lumbar_flexion',
                'icon'       => 'assets/img/parameters/lumbar_flexion.svg',
                'sort_order' => 2,
            ],
            [
                'key'        => 'lumbar_extension',
                'label'      => 'Lumbar Extension (°)',
                'unit'       => '°',
                'icon_key'   => 'lumbar_extension',
                'icon'       => 'assets/img/parameters/lumbar_extension.svg',
                'sort_order' => 3,
            ],
            [
                'key'        => 'side_flexion_right',
                'label'      => 'Side Flexion Right (°)',
                'unit'       => '°',
                'icon_key'   => 'side_flexion_right',
                'icon'       => 'assets/img/parameters/side_flexion_right.svg',
                'sort_order' => 4,
            ],
            [
                'key'        => 'side_flexion_left',
                'label'      => 'Side Flexion Left (°)',
                'unit'       => '°',
                'icon_key'   => 'side_flexion_left',
                'icon'       => 'assets/img/parameters/side_flexion_left.svg',
                'sort_order' => 5,
            ],
            [
                'key'        => 'straight_leg_raise_r',
                'label'      => 'Straight Leg Raise (R)',
                'unit'       => '°',
                'icon_key'   => 'straight_leg_raise_r',
                'icon'       => 'assets/img/parameters/straight_leg_raise_r.svg',
                'sort_order' => 6,
            ],
            [
                'key'        => 'straight_leg_raise_l',
                'label'      => 'Straight Leg Raise (L)',
                'unit'       => '°',
                'icon_key'   => 'straight_leg_raise_l',
                'icon'       => 'assets/img/parameters/straight_leg_raise_l.svg',
                'sort_order' => 7,
            ],
            [
                'key'        => 'core_strength',
                'label'      => 'Core Strength',
                'unit'       => 'grade',
                'icon_key'   => 'core_strength',
                'icon'       => 'assets/img/parameters/core_strength.svg',
                'sort_order' => 8,
            ],
            [
                'key'        => 'walking_tolerance',
                'label'      => 'Walking Tolerance (min)',
                'unit'       => 'min',
                'icon_key'   => 'walking_tolerance',
                'icon'       => 'assets/img/parameters/walking_tolerance.svg',
                'sort_order' => 9,
            ],
            [
                'key'        => 'sitting_tolerance',
                'label'      => 'Sitting Tolerance (min)',
                'unit'       => 'min',
                'icon_key'   => 'sitting_tolerance',
                'icon'       => 'assets/img/parameters/sitting_tolerance.svg',
                'sort_order' => 10,
            ],
            [
                'key'        => 'standing_tolerance',
                'label'      => 'Standing Tolerance (min)',
                'unit'       => 'min',
                'icon_key'   => 'standing_tolerance',
                'icon'       => 'assets/img/parameters/standing_tolerance.svg',
                'sort_order' => 11,
            ],
            [
                'key'        => 'sleep_quality',
                'label'      => 'Sleep Quality',
                'unit'       => 'grade',
                'icon_key'   => 'sleep_quality',
                'icon'       => 'assets/img/parameters/sleep_quality.svg',
                'sort_order' => 12,
            ],
            [
                'key'        => 'functional_disability',
                'label'      => 'Functional Disability (ODI%)',
                'unit'       => '%',
                'icon_key'   => 'functional_disability',
                'icon'       => 'assets/img/parameters/functional_disability.svg',
                'sort_order' => 13,
            ],
        ];

        foreach ($parameters as $param) {
            MasterParameter::updateOrCreate(
                ['key' => $param['key']],
                [
                    'label'      => $param['label'],
                    'unit'       => $param['unit'],
                    'icon_key'   => $param['icon_key'],
                    'icon'       => $param['icon'],
                    'sort_order' => $param['sort_order'],
                    'status'     => 'active',
                ]
            );
        }
    }
}
