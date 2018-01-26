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
function format_date($date, $format = 'd/m/Y', $from_format = null)
{
    if ($from_format != null) {
        $date = Carbon::createFromFormat($from_format, $date);
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
 * a classe 'has-error'.
 *
 * @param string $field Nome do campo do formulário
 * @return string
 */
function has_error_class($field)
{
    $errors = \Request::get('errors');
    if (empty($errors)) {
        return '';
    }

    return $errors->has('name') ? ' has-error' : '';
}
