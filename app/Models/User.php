<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ladder\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable, CausesActivity;

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

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // Super admin
    public function isAdmin(): bool
    {
        return $this->email === config('transittracker.admin_email');
    }
}
