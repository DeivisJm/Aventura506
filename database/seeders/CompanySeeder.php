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
                'email' => 'deivisjm05@hotmail.com',
                'phone' => '89482317',
                'location_name' => 'La Fortuna, San Carlos',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410282!2d-84.69038492631475!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771911312649!5m2!1ses-419!2scr',
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Espacio Publico'],
            [
                'email' => null,
                'phone' => null,
                'location_name' => 'La Fortuna, San Carlos',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.538692338868!2d-84.6456862263155!3d10.458132889671932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00d64b670b961%3A0x176ede279f5f79cf!2sParqueo%20Hijos%20del%20agua%2C%20Poza%20El%20Salto!5e0!3m2!1ses-419!2scr!4v1771911923580!5m2!1ses-419!2scr',
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Parque Nacional Volcán Arenal'],
            [
                'email' => null,
                'phone' => null,
                'location_name' => 'La Fortuna, San Carlos',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.745334485238!2d-84.6699524263158!3d10.44177198968739!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00db4da5826ab%3A0x3c6ad4ac1b7a026!2sCatarata%20R%C3%ADo%20Fortuna!5e0!3m2!1ses-419!2scr!4v1771951219987!5m2!1ses-419!2scr',
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Parque Nacional Volcán Tenorio'],
            [
                'email' => null,
                'phone' => null,
                'location_name' => 'Río Celeste, Guatuso',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d980.0603879875836!2d-84.98846612866033!3d10.71584313727108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f75549b110189a7%3A0x30169a76c5e96ef0!2sRio%20Celeste%20y%20Los%20Te%C3%B1ideros!5e0!3m2!1ses-419!2scr!4v1771956624348!5m2!1ses-419!2scr',
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Nature Tours La Fortuna'],
            [
                'email' => null,
                'phone' => null,
                'location_name' => 'La Pechuga, Chachagua, La Fortuna',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125574.06074963207!2d-84.72467422485353!3d10.406527146939155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa073003bf2ad75%3A0xdf75f26e7dcd45ac!2sNature%20Tours%20La%20Fortuna!5e0!3m2!1ses-419!2scr!4v1771977459502!5m2!1ses-419!2scr',
            ]
        );

        Company::updateOrCreate(
            ['name' => 'Sky Adventures Arenal'],
            [
                'email' => null,
                'phone' => null,
                'location_name' => 'La Fortuna, San Carlos',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.9498168152436!2d-84.7355444!3d10.425557099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00fb3384ca461%3A0xf167c8258d7570ba!2sSky%20Adventures!5e0!3m2!1ses-419!2scr!4v1771984429085!5m2!1ses-419!2scr',
            ]
        );
    }
}
