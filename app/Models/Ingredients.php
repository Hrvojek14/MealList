<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredients extends Model
{
    use HasFactory,  SoftDeletes;
    
    protected $fillable = ['slug', 'created_at'];
    protected $hidden = ['laravel_through_key'];

    //protected $visible = ['id', 'slug'];

    public function ingredient_translation()
    {
        return $this->belongsTo('App\Models\IngredientTranslation','slug','slug');
    }
}
