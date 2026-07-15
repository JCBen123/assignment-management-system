<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'user_id',
        'file_name',
        'mime_type',
        'path',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}