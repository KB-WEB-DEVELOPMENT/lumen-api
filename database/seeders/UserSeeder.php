<?php
 
namespace Database\Seeders;

use App\User;
 
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(['name' => 'name-user1-instructor1']);
		User::factory()->create(['name' => 'name-user2-instructor2']);
		User::factory()->create(['name' => 'name-user3-student1']);
		User::factory()->create(['name' => 'name-user4-student2']);
    }
}