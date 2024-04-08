<?php

namespace App\Http\Shared\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Support\Str;

/**
 * Class inspired by lukzgois.
 * https://github.com/lukzgois/request/blob/master/src/Request.php
 */
class FormRequest extends BaseFormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->autoRegister();
    }

    /**
     * Register the validate* methods found in the class
     */
    public function autoRegister()
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            $this->registerCustomRule($method);
        }
    }

    /**
     * Register a custom rule in the class.
     *
     * If the method matches the pattern validate*, then it will be registered like an validator extension
     */
    private function registerCustomRule(string $method)
    {
        if (! preg_match('/^validate.+/', $method)) {
            return;
        }

        $validationName = Str::snake(substr($method, 8));
        \Validator::extend($validationName, function ($attribute, $value, $parameters) use ($method) {
            return $this->$method($attribute, $value, $parameters);
        });
    }
}
