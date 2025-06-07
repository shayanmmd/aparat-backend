<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['خفن', 'دیدنی', 'سلبریتی'];

        foreach ($tags as $tagName) {
            Tag::create([
                'title' => $tagName
            ]);
        }
    }
}
