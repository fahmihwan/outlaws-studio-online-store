<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function credential()
    {
        return $this->hasOne(Credential::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
