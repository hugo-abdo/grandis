<?php

namespace App\Models;

use App\Notifications\Notification as UserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasRoles, HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            if (!auth()->guest()) {
                Notification::send(
                    User::role('admin')->whereNotIn('id', [auth()->id()])->get(),
                    new UserNotification('new user created by ' . auth()->user()->name)
                );
            }
        });
        static::updated(function ($model) {
            if (!auth()->guest()) {
                Notification::send(
                    User::role('admin')->whereNotIn('id', [auth()->id()])->get(),
                    new UserNotification('Update ' . $model->name . ' Profile.',
                        [
                            'user' => $model,
                            'action' => 'update-user',
                        ]
                    )
                );
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeFilter($query)
    {
        if (request()->has('status') && request()->status !== "all status") {
            $query->where('is_active', request()->status);
        }
        if (request()->has('role') && request()->role !== "all roles") {
            $query->role(request()->role);
        }

        !request()->name ?: $query->where('name', 'LIKE', '%' . request()->name . '%');
        !request()->email ?: $query->where('email', 'LIKE', '%' . request()->email . '%');
    }

    public function scopeCanSee($query)
    {
        $query->whereHas('roles', function ($q) {
            $q->whereIn('id', auth()->user()->roles->first()->canSee->pluck('id'));
        });
    }
}
