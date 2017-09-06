<?php
namespace DevMarketer\LaraFlash;
/**
 * This file is part of LaraFlash,
 * Improved flash messaging for Laravel.
 *
 * @license MIT
 * @package LaraFlash
 */

use Illuminate\Support\Facades\Facade;

class LaraFlashFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraflash';
    }
}
