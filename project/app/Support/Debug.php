<?php

namespace App\Support;

class Debug
{
    /**
     * Retorna o tempo, em milisegundos, que um método é executado.
     *
     * @param  callable  $function  Método a ser estressado
     * @param  int  $times  Quatidade de vezes que o método será executado
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do teste
     * @return int tempo de execução
     */
    public static function stress(callable $function, int $times = 1000, bool $dumpAndDie = true)
    {
        $initialTIme = milliseconds();

        for ($i = 0; $i < $times; $i++) {
            $function();
        }

        $resultTime = milliseconds() - $initialTIme;

        if ($dumpAndDie) {
            dd($resultTime);
        }

        return $resultTime;
    }

    /**
     *  Retorna o SQL já com os parâmetros associados
     *  Atenção! Só utilizar este método com finalidade de debug. Não utilizar para
     * outros fins.
     *
     * @param $queryBuilder
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do método
     * @return string
     */
    public static function eloquentSqlWithBindings($queryBuilder, bool $dumpAndDie = true): string
    {
        $sql = str_replace(['%', '?'], ['%%', '%s'], $queryBuilder->toSql());

        $handledBindings = array_map(function ($binding) {
            if (is_numeric($binding)) {
                return $binding;
            }

            $value = str_replace(['\\', "'"], ['\\\\', "\'"], $binding);

            return "'{$value}'";
        }, $queryBuilder->getConnection()
            ->prepareBindings($queryBuilder->getBindings()));

        $fullSql = vsprintf($sql, $handledBindings);

        if ($dumpAndDie) {
            dd($fullSql);
        }

        return $fullSql;
    }
}