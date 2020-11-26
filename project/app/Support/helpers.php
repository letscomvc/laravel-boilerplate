<?php
/**
 * All files in this folder will be included in the application.
 */

if (!function_exists('implode_with_comma')) {
    /**
     * Separar os ítens de uma array por vírgula.
     *
     * @param  string[]  $array  .
     * @param  string  $lastGlue
     * @param  string  $outputWhenEmpty
     * @return string
     */
    function implode_with_comma(
        array $array,
        string $lastGlue = ', ',
        string $outputWhenEmpty = ''
    ) {
        if (sizeof($array) == 0) {
            return $outputWhenEmpty;
        }

        if (sizeof($array) != 1) {
            $last = array_pop($array);
            $glued = implode($array, ', ');
            return $glued.$lastGlue.$last;
        }

        return implode($array, ', ');
    }
}

if (!function_exists('format_date')) {
    /**
     * Formata uma data
     *
     * @param  \Carbon\Carbon|string  $date  Date to format.
     * @param  string  $format  Format.
     * @param  string  $fromFormat  Origin format.
     * @return string
     */
    function format_date($date, $format = null, $fromFormat = null)
    {
        return \App\Support\DateHelper::formatDate($date, $format, $fromFormat);
    }
}

if (!function_exists('format_of_date')) {
    /**
     * Retorna o formato corrente de 'date'
     *
     * @return string
     */
    function format_of_date()
    {
        return \App\Support\DateHelper::getDateFormat();
    }
}

if (!function_exists('format_of_datetime')) {
    /**
     * Retorna o formato corrente de 'datetime'
     *
     * @return string
     */
    function format_of_datetime()
    {
        return \App\Support\DateHelper::getDateTimeFormat();
    }
}

if (!function_exists('generate_date_range')) {
    /**
     * Dado uma data inicial e uma final, retorna todos os dias entre elas
     *
     * @param  Carbon  $start_date  Data inicial
     * @param  Carbon  $end_date  Data final
     * @return array
     */
    function generate_date_range(\Carbon\Carbon $start_date, \Carbon\Carbon $end_date)
    {
        return \App\Support\DateHelper::generateDateRange($start_date, $end_date);
    }
}

if (!function_exists('convert_date_interval')) {
    /**
     * Dado um intervalo em string, converte para uma array com os devidos formatos
     * para o banco de dados
     *
     * @param  string  $period
     * @param  string  $periodSeparator
     * @return array
     */
    function convert_date_interval($period, string $periodSeparator = '-')
    {
        return \App\Support\DateHelper::convertDateInterval($period, $periodSeparator);
    }
}

if (!function_exists('_m')) {
    /**
     * Retorna mensagens do arquivo 'flash' de tradução.
     *
     * @param  mixed  $key  Chave do caminho para acessar.
     * @param  string  $default  Mensagem padrão caso não encontre a mensagem.
     * @return string
     */
    function _m(string $key, string $default = null): string
    {
        return __('flash.'.$key);
    }
}

if (!function_exists('with_error')) {
    /**
     *  Caso exista algum erro para o campo passado como parâmetro, é retornada
     * a classe 'form-control-danger'.
     *
     * @param  string  $field  Nome do campo do formulário
     * @param  callable|string|null  $output
     * @return string
     */
    function with_error(string $field, $output = 'has-danger'): string
    {
        $errors = \Session::get('errors');

        if (empty($errors)) {
            return '';
        }

        return $errors->has($field) ? value($output) : '';
    }
}

if (!function_exists('mask')) {
    /**
     *  Aplica uma máscara à uma string.
     *
     * @param  string  $value  Valor a ser mascarado
     * @param  string  $mask  Máscara
     * @param  string  $mask_character  Caractere que representará os valores preenchíveis
     * @return string
     */
    function mask($value, $mask, $mask_character = '#')
    {
        $value = str_replace(" ", "", $value);
        for ($i = 0; $i < strlen($value); $i++) {
            $mask[strpos($mask, $mask_character)] = $value[$i];
        }

        return $mask;
    }
}

if (!function_exists('pagination')) {
    /**
     * Retorna uma instância do builder de paginação.
     *
     * @return \App\Support\PaginationBuilder
     */
    function pagination()
    {
        return new \App\Support\PaginationBuilder();
    }
}

if (!function_exists('breadcrumb')) {
    /**
     * Retorna uma instância do helper BreadCrumb
     *
     * @return \App\Support\BreadCrumb
     */
    function breadcrumb()
    {
        return new \App\Support\BreadCrumb();
    }
}

if (!function_exists('flash')) {
    /**
     * Retorna uma instância do helper Flash
     *
     * @return \App\Support\Flash
     */
    function flash()
    {
        return new \App\Support\Flash();
    }
}

if (!function_exists('current_user')) {
    /**
     * Retorna uma instância do usuário corrente.
     *
     * @return \App\Models\User
     */
    function current_user()
    {
        return auth()->user();
    }
}

if (!function_exists('apply_params')) {
    /**
     * Aplica argumentos em parâmetros de uma string
     *
     * @return string
     */
    function apply_params(string $string, array $params, $before = ':', $after = '')
    {
        $regex = '/'.$before.'[a-z_]+'.$after.'/';
        return preg_replace_array($regex, $params, $string);
    }
}

if (!function_exists('in_production')) {
    /**
     * Retorna se a aplicação está em produção.
     *
     * @return bool
     */
    function in_production()
    {
        $actualEnv = env('APP_ENV', 'local');
        return (starts_with($actualEnv, 'prod'));
    }
}

if (!function_exists('milliseconds')) {
    /**
     * Retorna o timestamp atual em milisegundos
     *
     * @return int
     */
    function milliseconds()
    {
        $microTime = explode(' ', microtime());
        return ((int) $microTime[1]) * 1000 + ((int) round($microTime[0] * 1000));
    }
}

if (!function_exists('stress')) {
    /**
     * Retorna o tempo, em milisegundos, que um método é executado.
     *
     * @param  callable  $function  Método a ser estressado
     * @param  int  $times  Quatidade de vezes que o método será executado
     * @param  bool  $dumpAndDie  Encerrar a aplicação com o resultado do teste
     * @return int tempo de execução
     */
    function stress(callable $function, int $times = 1000, bool $dumpAndDie = true)
    {
        return \App\Support\Debug::stress($function, $times, $dumpAndDie);
    }
}

if (!function_exists('cached_include')) {
    /**
     * Mimics the blade include function but caches the rendered for $time
     * minutes in key 'cache:partials:<view_name>:<context>_<$cache_key>'
     * in order to avoid conflicts and to be able to flush the view using
     * patterns.
     *     Ex: Cache::clear('cache:partials:myview_*');
     *
     * @param  string  $view  The name of the view that are going to be included.
     * @param  array  $vars  Variables that are being passed to the view.
     * @param  integer  $time  The amount of minutes that the result of the view is going to be stored.
     *
     * @return string             Html code of the included view
     */
    function cached_include($view, $vars = null, $time = 60)
    {
        $renderedView = function () use ($view, $vars) {
            $vars = is_array($vars)
                ? $vars
                : array_except(get_defined_vars(), ['__data', '__path']);

            return view($view, $vars)->render();
        };

        $cacheKey = $view.':'.md5(serialize($vars));
        return cache_manager($cacheKey, $time.' minutes', $renderedView);
    }
}

if (!function_exists('cache_manager')) {
    /**
     *  Resolve o resultado de uma chave de cache e retorna seu valor. Caso chamado
     * sem nenhum argumento, retorna uma instancia de \App\Helpers\CacheManager.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  callable  $value  Valor a ser criado cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    function cache_manager()
    {
        $args = func_get_args();
        $cacheManager = app()->make(\App\Support\CacheManager::class);

        if (empty($args)) {
            return $cacheManager;
        }

        return $cacheManager->remember(...$args);
    }
}

if (!function_exists('request_cache')) {
    /**
     *  Faz cache de um resultado apenas durante a requisição atual.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  callable  $value  Valor a ser criado cache
     * @return mixed
     */
    function request_cache($key, callable $value)
    {
        $cacheManager = app()->make(\App\Support\CacheManager::class);
        return $cacheManager->requestCache($key, $value);
    }
}

if (!function_exists('strbool')) {
    /**
     * Retorna a string de um valor booleano.
     *
     * @param $value
     * @return string
     */
    function strbool(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}

if (!function_exists('is_valid_url')) {
    /**
     * Validate if param is a valid URL;
     *
     * @param  string  $uil
     * @return boolean
     */
    function is_valid_url(string $url)
    {
        return (bool) filter_var($url, FILTER_VALIDATE_URL);
    }
}
