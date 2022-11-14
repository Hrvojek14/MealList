<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MealTag extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $table = 'meals_tags';

    protected $hidden = ['laravel_through_key'];
    
}
