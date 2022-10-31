<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CategoryTranslation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'slug', 'locale'];
    protected $hidden = ['laravel_through_key'];
    
    protected $visible = ['id', 'title', 'slug'];

    public function category() {
        return $this->belongsTo('App\Models\Category','slug','slug');
    }
    
    public function language(){
        return $this->belongsTo('App\Models\Languages','locale', 'lang');
    }
}
