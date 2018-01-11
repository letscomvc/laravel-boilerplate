<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Builders\PaginationBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $pagination;

    public function __construct()
    {
        $this->pagination = new PaginationBuilder();
    }

    public function pagination()
    {
        $this->getPagination();
        return $this->pagination->build();
    }

    protected function getPagination()
    {
    }
}
