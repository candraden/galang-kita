<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model   // ganti nama class sesuai file
{
    protected $guarded = [];

    public function group()
{
    return $this->belongsTo(Group::class);
}
}
