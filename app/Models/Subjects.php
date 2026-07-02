<?php

namespace App\Models;

use App\Models\Assignments;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'code',
        'remarks',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignments::class, 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
