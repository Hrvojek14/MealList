<?php

namespace App\Helpers;



/**
 * Class ApiHelper
 *
 *
 * @package Modules\MCard\Helpers
 * @version   2.0
 * @since     2.0
 */
class ApiHelper
{

    public static function get_array($string){
        return explode(',', $string);   
    }


}



