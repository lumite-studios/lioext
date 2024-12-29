<?php

namespace App\Actions\Dev\RLC;

use App\Actions\Action;
use Illuminate\Support\Facades\Storage;

class SetUpdate extends Action
{
    public function handle(string $key, mixed $value)
    {
        $path = '/dev/updates.json';
        $updates = json_decode(Storage::get($path), true);

        $updates[$key] = $value;

        Storage::put($path, json_encode($updates));
    }
}
