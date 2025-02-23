<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::insert([
            [
                'name' => 'Отправлен',
                'description' => 'Документ был отправлен получателю',
            ],
            [
                'name' => 'Получен',
                'description' => 'Документ был получен получателем',
            ],
            [
                'name' => 'Просмотрен',
                'description' => 'Документ был просмотрен получателем',
            ],
        ]);
    }
}
