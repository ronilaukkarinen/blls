<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Space extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // Relations
    public function users() {
        return $this->belongsToMany(User::class, 'user_space');
    }
}
