<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'salary',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
    ];

    public function nurses()
    {
        return $this->hasMany(Nurse::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
