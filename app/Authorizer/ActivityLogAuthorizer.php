<?php

namespace App\Authorizer;

use App\Models\User;

class ActivityLogAuthorizer
{
    public function __invoke(User $user): bool
    {
        return $user->isAdmin();
    }
}
