<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingletonController extends Controller
{
    //
}

class Singleton
{
    private static $instance;

    private function __construct()
    {
        // Private constructor to prevent instantiation outside the class.
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Other methods of the singleton class...
}

// Usage
$singleton1 = Singleton::getInstance();
$singleton2 = Singleton::getInstance();

var_dump($singleton1 === $singleton2); // This should output true
