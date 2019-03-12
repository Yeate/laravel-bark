<?php

namespace Pokeface\BarkPush\Facades;
use Illuminate\Support\Facades\Facade;


class BarkPush extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BarkPush';
    }
}
