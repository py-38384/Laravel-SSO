<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;
use App\Services\SharedEncrypterService;

class SharedEncrypt extends Facade
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    protected static function getFacadeAccessor(){
        return SharedEncrypterService::class;
    }
}
