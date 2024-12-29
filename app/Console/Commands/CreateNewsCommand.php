<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

use function Laravel\Prompts\textarea;

class CreateNewsCommand extends Command
{
    protected $signature = 'app:news';

    protected $description = 'Create a news post.';

    public function handle()
    {
        $content = textarea('Content');

        $post = Post::create([
            'content' => $content,
        ]);

        dd($post);
    }
}
