<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AboutModel;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutModel::create([
            'name' => 'Melchard Lina',
            'birthdate' => 'January 6, 2003',
            'age' => 21,
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'contactNo' => '09307696919',
            'address' => 'Brgy. Hampangan Hilongos, Leyte',
            'email' => 'dvoid367@gmail.com'
        ]);
    }
}
