<?php namespace Mpedrera\Themify\Facades;

use Illuminate\Support\Facades\Facade;

class Themify extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'themify';
    }

}