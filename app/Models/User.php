<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ladder\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForSlack(): string
    {
        return config('transittracker.slack_webhook_url');
    }

    public function canAccessFilament(): bool
    {
        return true;
    }

    // Super admin
    public function isAdmin(): bool
    {
        return $this->email === config('transittracker.admin_email');
    }
}
