<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'arrival',
        'name',
        'late',
    ];

    protected $casts = [
        'arrival' => 'datetime',
        'late' => 'boolean',
    ];

    public function getFormattedArrivalAttribute()
    {
        return $this->arrival->format('H:i:s');
    }

    public function getStatusAttribute()
    {
        return $this->late ? 'Late' : 'On Time';
    }

    public function getStatusClassAttribute()
    {
        return $this->late ? 'text-red-600' : 'text-green-600';
    }

    public function scopeToday($query)
    {
        return $query->whereDate('arrival', today());
    }

    public function scopeLate($query)
    {
        return $query->where('late', true);
    }

    public function scopeOnTime($query)
    {
        return $query->where('late', false);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('arrival', $date);
    }

    public static function validateData($data)
    {
        $errors = [];

        // validate name
        if (empty($data['name'])) {
            $errors[] = 'Name is required';
        } elseif (strlen($data['name']) < 2) {
            $errors[] = 'Name must be at least 2 characters';
        } elseif (strlen($data['name']) > 50) {
            $errors[] = 'Name cannot exceed 50 characters';
        } elseif (!preg_match('/^[a-zA-Z\s\-\'\.]+$/', $data['name'])) {
            $errors[] = 'Name contains invalid characters';
        }

        return $errors;
    }
}