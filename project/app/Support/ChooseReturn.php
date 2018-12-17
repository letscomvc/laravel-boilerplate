<?php

namespace App\Support;

use Illuminate\Contracts\Support\Responsable;

class ChooseReturn implements Responsable
{
    /**
     * Response type
     * @var string
     */
    private $type;

    /**
     * Response payload
     * @var mixed
     */
    private $data;

    /**
     * Redirection route
     * @var string
     */
    private $route;

    /**
     * Response Message
     * @var string
     */
    private $message;

    /**
     * Return a configured instance from ChooseReturn
     * @param string $type success|error|info|warning
     * @param string $message Response message
     * @param string $route get route or routeName
     * @param mixed $routeArguments Route arguments when preceded by route name
     * @return self Configured ChooseReturn
     */
    public static function choose($type, $message, $route = null, $routeArguments = null)
    {
        $chooseReturnInstance = new self();

        $chooseReturnInstance->setType($type)
            ->setMessage($message);

        if ($route) {
            $chooseReturnInstance->setRoute($route, $routeArguments);
        }

        return $chooseReturnInstance;
    }

    /**
     * Set response type
     * @param string $type success|error|info|warning
     */
    public function setType($type)
    {
        if (! in_array($type, ['success', 'error', 'info', 'warning'])) {
            throw new \InvalidArgumentException("Invalid response type [{$type}]", 500);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Set redirection route
     * @param string $route get route or routeName
     * @param mixed $routeArguments When preceded by route name, route arguments
     */
    public function setRoute($route, $routeArguments = null)
    {
        $this->route = is_valid_url($route)
            ? $route
            : route($route, $routeArguments);

        return $this;
    }

    /**
     * Set response message
     * @param string $message Response message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set payload data
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Build the HTTP response according to the parameters
     * @return mixed HTTP response
     */
    public function build()
    {
        if (\Request::ajax()) {
            return $this->ajaxResponse();
        }

        if ($this->route) {
            return $this->redirectResponse();
        }

        throw new \BadMethodCallException('Redirect without route.', 500);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return $this->build();
    }

    /**
     * Generates an ajax response according to the current attributes
     * @return \Illuminate\Http\Response Ajax Response
     */
    private function ajaxResponse()
    {
        $response = [
            'type' => $this->type,
            'message' => $this->message ?? null,
        ];

        if ($this->data) {
            $response['data'] = $this->data;
        }
        $code = ($this->type === 'error') ? 202 : 200;

        return response(json_encode($response), $code);
    }

    /**
     * Generates an redirect response and throw a flash message
     * @return \Illuminate\Http\RedirectResponse Redirect response
     */
    private function redirectResponse()
    {
        flash()->create($this->type, $this->message);
        return redirect()->to($this->route);
    }
}
