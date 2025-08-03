<?php

// app/Models/Customer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'loyalty_points'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'loyalty_points' => 'integer'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}