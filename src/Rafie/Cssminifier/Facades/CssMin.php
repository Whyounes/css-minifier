<?php 
namespace Rafie\Cssminifier\Facades;

use Illuminate\Support\Facades\Facade;

class CssMin extends Facade{

    protected static function getFacadeAccessor() { return 'cssmin'; }
}
