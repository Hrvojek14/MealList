<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    
    public $timestamps = true;
    protected $fillable = ['slug', 'created_at'];
    protected $hidden = ['laravel_through_key'];

    //protected $visible = ['id', 'slug'];

    public function category_translation()
    {
        return $this->belongsTo('App\Models\CategoryTranslation','slug','slug');
    }

}
