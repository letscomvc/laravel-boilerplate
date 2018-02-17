<?php
/**
 * All files in this folder will be included in the application.
 */


/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param array $array Array que será dividida.
 * @return string
 */
function separe_by_comma($array)
{
    return implode(', ', $array);
}

/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param Date $date Date to format.
 * @param string $format Format.
 * @param string $from_format Origin format.
 * @return string
 */
function format_date($date, $format = 'd/m/Y H:i:s', $from_format = null)
{
    if ($date instanceof \Carbon\Carbon) {
        return $date->format($format);
    }

    if ($from_format != null) {
        $date = \Carbon\Carbon::createFromFormat($from_format, $date);
    } else {
        $date = \Carbon\Carbon::parse($date);
    }

    return $date->format($format);
}

/**
 * Retorna mensagens padrões dentro do arquivo 'messages' de tradução.
 *
 *  A chave será buscada em messages.common.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, a chave passada por parâmetro é retornada.
 *
 * @param string $key Chave do caminho para acessar.
 * @return string
 */
function get_common_message_translate($key)
{
    $path = "messages.common.{$key}";
    $translated = __($path);
    if ($path === $translated) {
        return $key;
    }
    return $translated;
}


/**
 * Retorna mensagens do arquivo 'messages' de tradução.
 *
 *  A chave será buscada em messages.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, tentará retornar a mensagem padrão. Caso não encontre
 * também, será retornada a chave completa.
 *
 * @param mixed $key Chave do caminho para acessar. Pode ser uma string ou
 * uma array com as seguintes chaves: 'domain' e 'message_path'.
 * @param string $default Mensagem padrão caso não encontre a chave.
 * @return string
 */
function find_message($key, $default = null)
{
    $separated_key = $key;
    if (! is_array($separated_key)) {
        $exploded = explode('.', $separated_key);
        $separated_key = [];
        $separated_key['domain'] = head($exploded);
        $separated_key['message_path'] = implode('.', array_slice($exploded, 1));
    }

    $message_path = implode('.', array_flatten($separated_key));
    $message_path = "messages.{$message_path}";

    $translated = __($message_path);

    if ($translated === $message_path) {
        if ($default != null) {
            return $default;
        }
        $common = get_common_message_translate($separated_key['message_path']);
        if ($common === $separated_key['message_path']) {
            return $message_path;
        }
        return $common;
    }

    return $translated;
}

/**
 * Alias para 'find_message'. Retorna mensagens do arquivo 'messages' de tradução.
 *
 *  A chave será buscada em messages.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, tentará retornar a mensagem padrão. Caso não encontre
 * também, será retornada a chave completa.
 *
 * @param mixed $key Chave do caminho para acessar. Pode ser uma string ou
 * uma array com as seguintes chaves: 'domain' e 'message_path'.
 * @param string $default Mensagem padrão caso não encontre a chave.
 * @return string
 */
function _m($key, $default = null)
{
    return find_message($key, $default);
}

/**
 *  Caso exista algum erro para o campo passado como parâmetro, é retornada
 * a classe 'is-invalid'.
 *
 * @param string $field Nome do campo do formulário
 * @return string
 */
function has_error_class($field)
{
    $errors = \Session::get('errors');
    if (empty($errors)) {
        return '';
    }

    return $errors->has($field) ? 'is-invalid' : '';
}

/**
 *  Aplica uma máscara à uma string.
 *
 * @param string $value Valor a ser mascarado
 * @param string $mask Máscara
 * @param string $mask_character Caractere que representará os valores preenchíveis
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

/**
 * Retorna se o prefixo da rota atual é igual ao parametro passado
 * ex: users.index, users.create.
 * prefixo: users
 *
 * @param string $routeName Nome da Rota
 * @return boolean
 */
function is_current_route($route_name)
{
    $route_name_prefix = implode('.', explode('.', $route_name, -1));
    $route_compare_prefix = implode('.', explode('.', Route::currentRouteName(), -1));

    $has_same_prefix = ($route_compare_prefix === $route_name_prefix);
    $is_actual_route = ($route_name === Route::currentRouteName());

    return ($has_same_prefix || $is_actual_route);
}

/**
 *  Caso o prefixo da rota atual seja igual ao parâmetro passado, é retornada
 * a classe 'active'.
 *
 * @param string $field Nome do campo do formulário
 * @return string
 */
function is_active($routeName, $output = 'active')
{
    return (is_current_route($routeName)) ? $output : '';
}

function is_active_routes(array $routes, $output = 'active')
{
    $current_route_name = Route::currentRouteName();
    $is_active = in_array($current_route_name, $routes);
    return ($is_active) ? $output : '';
}

function user_has_role_name($name)
{
    $user = \Illuminate\Support\Facades\Auth::user();

    return $user->getRoleNames()->contains($name);
}
