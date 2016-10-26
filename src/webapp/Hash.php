<?php

namespace tdt4237\webapp;

use Symfony\Component\Config\Definition\Exception\Exception;

class Hash
{

    public function __construct()
    {
    }

    public static function make($plaintext)
    {
        $salt = bin2hex(random_bytes(20));
        return hash('sha256', $plaintext . $salt) . $salt;

    }

    private function generateHash($plaintext, $hash) 
    {
        $salt = substr($hash, 64);
        return hash('sha256', $plaintext . $salt) . $salt;
    }

    public function check($plaintext, $hash)
    {
        return $this->generateHash($plaintext, $hash) === $hash;
    }

}
