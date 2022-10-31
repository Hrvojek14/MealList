<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meal_categories';
    protected $hidden = ['laravel_through_key'];
    
    protected $visible = ['meal_slug', 'category_slug'];

    
    public function category()
    {
        return $this->belongsTo('App\Models\Category','slug','category_slug');
    }
    
    public function meal()
    {
        return $this->belongsTo('App\Models\Meals','slug','meal_slug');
    }
}
