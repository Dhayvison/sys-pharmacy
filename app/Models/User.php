<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUuids, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'avatar',
        'google_id',
        'google_token',
        'google_refresh_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
        'google_token',
        'google_refresh_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function hasVerifiedEmail()
    {
        if (env('MAIL_MAILER') !== 'smtp') {
            return true;
        }
        if (!$this->hasRole('client') || $this->google_id) {
            return true;
        }
        return parent::hasVerifiedEmail();
    }

    public function sendEmailVerificationNotification()
    {
        if ($this->hasRole('client')) {
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        } else {
            throw new Exception('Only "client" users must verify e-mail');
        }
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function getHomePageName(): string
    {
        return $this->isClient() ? 'home' : 'dashboard';
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            $query->where('name', 'ilike', '%' . $search . '%')
                ->orWhere('email', 'ilike', '%' . $search . '%');
        });
    }
}
