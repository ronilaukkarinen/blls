<?php

namespace App\Policies;

use App\User;

class RecurringPolicy {
    public function view(User $user, Recurring $recurring) {
        return $user->spaces->contains($recurring->space_id);
    }
}
