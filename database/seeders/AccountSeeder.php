<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{

    public function run(): void
    {
        Account::create([
            'name' => 'Bancolombia',
            'type_account' => 'Ahorros',
            'number' => 123456789,
            'teacher_id' => 1,
        ]);
    }
}
