<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealIngredient extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meal_ingredients';
    protected $hidden = ['laravel_through_key'];
    
    protected $visible = ['meal_slug', 'ingredient_slug'];

    
    public function ingredient()
    {
        return $this->belongsTo('App\Models\Ingredients','slug','ingredient_slug');
    }
    
    public function meal()
    {
        return $this->belongsTo('App\Models\Meals','slug','meal_slug');
    }
}
