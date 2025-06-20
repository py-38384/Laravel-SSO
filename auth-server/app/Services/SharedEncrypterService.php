<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;

class SharedEncrypterService
{
    /**
     * Create a new class instance.
     */
    protected $encrypter;
    public function __construct()
    {
        $key = base64_decode(config("app.shared_encryption_key"));
        $this->encrypter = new Encrypter($key,'AES-256-CBC');
    }
    public function encrypt($value){
        return $this->encrypter->encrypt($value);
    }
    public function decrypt($value){
        try{
            return $this->encrypter->decrypt($value);
        } catch(\Exception $e){
            return null;
        }
    }
}
