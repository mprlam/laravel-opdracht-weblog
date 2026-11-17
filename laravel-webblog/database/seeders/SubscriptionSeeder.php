<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        // Dit is letterlijk waar factories voor zijn...
        $premiumArticles = Article::where('premium', 1)->get();
        foreach($premiumArticles as $article){
            // attach random users to random premium articles. miss 1 tot 3 users per article?
            $subscribedUsers = User::inRandomOrder()->random(1,3)->get();
            foreach($subscribedUsers as $user){
                Subscription::create(); // hoe doe je dit?
            }
        }
        */
        Subscription::factory()->count(10)->create();
    }
}
