<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

class Post extends Model
{
    use Orbital;

    public static $driver = 'json';

    protected $fillable = [
        'content',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public static function schema(Blueprint $table)
    {
        $table->id();
        $table->longText('content');
    }
}
