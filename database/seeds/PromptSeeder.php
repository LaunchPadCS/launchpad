<?php

use App\Models\InterviewPrompt;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InterviewPrompt::firstOrCreate(['prompt' => 'interview prompt text']);
    }
}
