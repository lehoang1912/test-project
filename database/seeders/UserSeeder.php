<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@email.com',
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'email' => 'engineer@email.com',
            'role' => User::ROLE_ENGINEER,
        ]);

        $engineers = User::factory()->count(20)->create();
        $engineers->each(function ($engineer) {
            $job = Job::factory()->create([
                'user_id' => $engineer->id
            ]);

            Certificate::factory()->create([
                'job_id' => $job->id
            ]);
        });
    }
}
