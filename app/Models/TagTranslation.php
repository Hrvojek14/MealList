<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagTranslation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'slug', 'locale'];

    public function tags() {
        return $this->belongsTo('App\Models\Tags','slug','slug');
    }
    
    public function language(){
        return $this->belongsTo('App\Models\Languages','locale', 'lang');
    }

}
