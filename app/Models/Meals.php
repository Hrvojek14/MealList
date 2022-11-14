<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meals extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['slug', 'created_at'];
    protected $hidden = ['laravel_through_key'];
    
    public function meal_ingredient()  {
        return $this->hasMany('App\Models\MealIngredient','meal_slug','slug');
    }

    public function meal_translation()  {
        return $this->hasMany('App\Models\MealTranslation','meal_slug','slug');
    }

    public function ingredients()
    {
        return $this->hasManyThrough(
            Ingredients::class, 
            MealIngredient::class,
            'meal_slug',
            'slug',
            'slug',
            'ingredient_slug');
    }

    public function tags()
    {
        return $this->hasManyThrough(
            Tags::class, 
            MealTag::class,
            'meal_slug',
            'slug',
            'slug',
            'tag_slug');
    }
    
    public function categories()
    {
        return $this->hasManyThrough(
            Category::class, 
            MealCategory::class,
            'meal_slug',
            'slug',
            'slug',
            'category_slug');
    }
}
