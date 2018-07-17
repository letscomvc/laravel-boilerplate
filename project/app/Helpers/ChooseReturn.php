<?php

namespace App\Helpers;

use Request;

class ChooseReturn
{
    public static function choose($type, $message, $route = null, $id = null)
    {
        if (! in_array($type, ['success', 'error', 'info', 'warning'])) {
            throw new \InvalidArgumentException("Invalid response type [{$type}]", 500);
        }

        if (Request::ajax()) {
            $response['type'] = $type;
            $response['message'] = $message;

            $code = ($type === 'error') ? 202 : 200;

            return response(json_encode($response), $code);
        }

        if ($route) {
            flash()->create($type, $message);
            return $id ? redirect()->route($route, $id) : redirect()->route($route);
        }

        throw new \BadMethodCallException('Redirect without route.', 500);
    }
}
