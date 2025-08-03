<?php

// app/Models/Supplier.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'country',
        'rating'
    ];

    protected $casts = [
        'rating' => 'decimal:1'
    ];

    public function coffees()
    {
        return $this->hasMany(Coffee::class);
    }
}