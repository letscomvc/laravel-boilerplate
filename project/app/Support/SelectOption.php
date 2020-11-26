<?php

namespace App\Support;

use App\Traits\Newable;
use \JsonSerializable;

class SelectOption implements JsonSerializable
{
    use Newable;

    protected $text = null;
    protected $value = null;

    /**
     * Classe utilizada para representar cada ítem de um Select de opções.
     *
     * @param  string  $value  Valor da opção
     * @param  string  $text  Texto a ser exibido
     */
    public function __construct(string $value, string $text)
    {
        $this->text = $text;
        $this->value = $value;
    }

    /**
     * Obter o valor atribuído à opção
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Obtém o texto a ser exibido atribuído à opção
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Configuração da serialização para JSON
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'value' => $this->getValue(),
            'text' => $this->getText(),
        ];
    }
}
