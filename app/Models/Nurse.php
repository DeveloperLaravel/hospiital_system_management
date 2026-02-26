<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'department_id',
    ];

    // العلاقة مع القسم
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
