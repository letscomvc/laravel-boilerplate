<?php

namespace App\Helpers;

use Request;
use Psy\Util\Json;

class ChooseReturn
{
    public static function choose($type, $message, $route = null)
    {
        if (! in_array($type, ['success', 'error', 'info', 'warning'])) {
            throw new \InvalidArgumentException("Invalid response type [{$type}]", 500);
        }

        if (Request::ajax()) {
            $response['type'] = $type;
            $response['message'] = $message;

            $code = ($type === 'error') ? 202 : 200;

            return response(Json::encode($response), $code);
        }

        if ($route) {
            return redirect()->route($route)->with($type, $message);
        }
    }
}
