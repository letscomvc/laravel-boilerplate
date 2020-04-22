<?php

namespace App\Http\Controllers;

use App\Support\ChooseReturn;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Escolhe a forma correta de retorno (XHR ou Redirect).
     *
     * @param  string  $type  Tipo do retorno ('error', 'success', 'info', 'warning')
     * @param  string  $message  Mensagem de retorno.
     * @param  string|null  $route  Rota para redirecionamento caso não seja XHR.
     * @param  string|null  $routeArguments Argumentos para construção da rota.
     * @return mixed JSON ou Redirect;
     */
    public function chooseReturn(
        string $type,
        string $message,
        ?string $route = null,
        $routeArguments = null
    ) {
        return ChooseReturn::choose($type, $message, $route, $routeArguments);
    }
}
