<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::updateOrCreate(
            ['name' => 'Natura Eco Park Costa Rica'],
            [
                'location_name' => 'La Fortuna, San Carlos',
                'latitude' => 10.5001259,
                'longitude' => -84.6903849,
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410282!2d-84.69038492631475!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771911312649!5m2!1ses-419!2scr',
                'map_directions_url' => 'https://www.google.com/maps/place/Natura+Eco+Park+-+Costa+Rica/@10.5001259,-84.6903849'
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Natural Public Spot'],
            [
                'location_name' => 'La Fortuna, San Carlos',
                'latitude' => 10.4586125,
                'longitude' => -84.6448624,
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.538692338868!2d-84.6456862263155!3d10.458132889671932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00d64b670b961%3A0x176ede279f5f79cf!2sParqueo%20Hijos%20del%20agua%2C%20Poza%20El%20Salto!5e0!3m2!1ses-419!2scr!4v1771911923580!5m2!1ses-419!2scr',
                'map_directions_url' => 'https://www.google.com/maps/place/Poza+El+Salto/@10.4581328,-84.6456862'
            ]
        );
    }
}
