<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealTranslation extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description'];

    public function meals() {
        return $this->belongsTo('App\Models\Meals','slug','slug');
    }

    public function language(){
        return $this->belongsTo('App\Models\Languages','locale', 'lang');
    }
}
