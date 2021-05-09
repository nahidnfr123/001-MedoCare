<?php

use App\BlogView;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogView::insert([
            'ip_address' => '127.0.0.1',
            'blog_id' => 6,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.2',
            'blog_id' => 6,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.3',
            'blog_id' => 6,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.4',
            'blog_id' => 6,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.5',
            'blog_id' => 7,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.6',
            'blog_id' => 7,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.7',
            'blog_id' => 7,
            'user_id' => 4,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.8',
            'blog_id' => 7,
            'user_id' => 5,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.9',
            'blog_id' => 3,
            'user_id' => 3,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.10',
            'blog_id' => 3,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.11',
            'blog_id' => 3,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.12',
            'blog_id' => 3,
            'user_id' => 0,
            'created_at' => Carbon::now(),
        ]);
        BlogView::insert([
            'ip_address' => '127.0.0.13',
            'blog_id' => 7,
            'user_id' => 2,
            'created_at' => Carbon::now(),
        ]);


    }
}
