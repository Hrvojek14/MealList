<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meal_tags';

    protected $hidden = ['laravel_through_key'];
    
    protected $visible = ['meal_slug', 'tag_slug'];

    
    public function tag()
    {
        return $this->belongsTo('App\Models\Tags','slug','tag_slug');
    }
    
    public function meal()
    {
        return $this->belongsTo('App\Models\Meals','slug','meal_slug');
    }
}
