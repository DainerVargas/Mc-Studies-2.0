<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{

   public function run(): void
   {
      Group::create([
         'name' => 'MC-STUDIES',
         'type_id' => 2,
         'teacher_id' => 1,
      ]);
      Group::create([
         'name' => 'MC-KIDS',
         'type_id' => 1,
         'teacher_id' => 2,
      ]);
   }
}
