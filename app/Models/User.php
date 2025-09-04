<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function getLogsAttribute()
    {
        return \App\Models\Log::where('name', $this->name)->get();
    }

    public function getTotalArrivalsAttribute()
    {
        return \App\Models\Log::where('name', $this->name)->count();
    }

    public function getLateArrivalsAttribute()
    {
        return \App\Models\Log::where('name', $this->name)->where('late', true)->count();
    }

    public function getOnTimeArrivalsAttribute()
    {
        return $this->total_arrivals - $this->late_arrivals;
    }

    public function getPunctualityRateAttribute()
    {
        if ($this->total_arrivals === 0) {
            return 0;
        }

        return round(($this->on_time_arrivals / $this->total_arrivals) * 100, 1);
    }

    public function hasLoggedToday()
    {
        return \App\Models\Log::where('name', $this->name)
            ->whereDate('arrival', today())
            ->exists();
    }

    public function getTodayLog()
    {
        return \App\Models\Log::where('name', $this->name)
            ->whereDate('arrival', today())
            ->first();
    }
}
