<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;

    protected $fillable = [       
        'customer_id',  'number',  'status'
    ];

    public function number_preferences()
    {
        return $this->hasMany(NumberPreference::class, 'number_id', 'id');
    }
}
