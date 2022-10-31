<?php


namespace App\Helpers;

use App\Models\Languages;


class SeederHelper  {

    public static function getLanguages(){
        $langs = Languages::select('lang')->orderBy('lang', 'asc')->groupBy('lang')->get();
        //$num_langs = count($langs);
        return $langs;
    }
}