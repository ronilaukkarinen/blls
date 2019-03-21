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

    public function recurrings() {
        return $this->hasMany(Recurring::class);
    }

    public function monthlyRecurrings($year, $month) {
        $query = DB::selectOne('
            SELECT SUM(amount) as amount
            FROM recurrings
            WHERE space_id = :space_id AND YEAR(starts_on) >= :start_year AND MONTH(starts_on) >= :start_month AND ((YEAR(ends_on) <= :end_year AND MONTH(ends_on) <= :end_month) OR ends_on IS NULL)
        ', ['space_id' => $this->id, 'start_year' => $year, 'start_month' => $month, 'end_year' => $year, 'end_month' => $month]);

        return $query->amount;
    }
}
