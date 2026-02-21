<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [

            'natura-plus' => [
                '08:00',
                '09:30',
                '10:00',
                '12:30',
                '14:30',
                '15:30',
            ],

            'caminata-nocturna' => [
                '18:00',
            ],
            'entrada-admision-natura' => [
                '08:30',
                '09:30',
                '10:30',
                '11:30',
                '12:30',
                '13:30',
                '14:30',
                '15:30',
                '16:30',
            ],
            'photography-tour' => [
                '09:00',
                '15:00',
            ],
            'bird-watching-tour' => [
                '06:00',
            ],

        ];

        foreach ($schedules as $slug => $times) {
            $tour = Tour::where('slug', $slug)->first();

            if ($tour) {
                $tour->schedules()->delete();

                foreach ($times as $time) {
                    $tour->schedules()->create([
                        'start_time' => $time,
                    ]);
                }
            }
        }
    }
}
