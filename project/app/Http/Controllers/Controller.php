<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Support\ChooseReturn;
use App\Builders\PaginationBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Retorna a paginação completa.
     *
     *  Cria o construtor de paginação, delega a configuração para o hook 'getPagination'
     * e retorna a paginação construída.
     *
     * @return Pagination
     */
    public function pagination()
    {
        $pagination = new PaginationBuilder();
        $this->getPagination($pagination);
        return $pagination->build();
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     */
    protected function getPagination($pagination)
    {
    }

    /**
     * Escolhe a forma correta de retorno (XHR ou Redirect).
     *
     * @param string $type Tipo do retorno ('error', 'success', 'info', 'warning')
     * @param string $message Mensagem de retorno.
     * @param string $route_to_redirect Rota para redirecionamento caso não seja XHR.
     * @return mixed JSON ou Redirect;
     */
    public function chooseReturn($type, $message, $route_to_redirect = null, $id = null)
    {
        return ChooseReturn::choose($type, $message, $route_to_redirect, $id);
    }
}
