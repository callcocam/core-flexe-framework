<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 01:11
 */

namespace Flexe\Storage;


class Session implements StorageInterface
{

    /**
     * Prefixo das sessões.
     */
    const PREFIX = 'storage_session';

    public static function factory(){

        return new Session();

    }

    /**
     * Usar para armazenar um valor no storage.
     *
     * @param string $name Nome do indice para o valor
     * @param $value
     * @param null $timeout
     * @return Session
     */
    public function set(string $name, $value, $timeout = null)
    {
        $_SESSION[self::PREFIX][$name] = $value;

        if ($timeout && is_int($timeout)) {
            $_SESSION[self::PREFIX][$name.'_created_at'] = time();
            $_SESSION[self::PREFIX][$name.'_timeout'] = $timeout;
        }

        return $this;
    }

    /**
     * Usar para resgatar um valor no storage.
     *
     * @param string $name Nome do indice que o valor foi armazenado
     *
     * @return *
     */
    public function get(string $name)
    {
        if ($this->exists($name)) {
            if (!$this->hasExpired($name)) {
                return $_SESSION[self::PREFIX][$name];
            } else {
                return false;
            }
        }
    }

    /**
     * Usar para verificar se um indice existe no storage.
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name): bool
    {
        return isset($_SESSION[self::PREFIX][$name]);
    }


    /**
     * Verifica se uma sessão já expirou.
     *
     * @param string $name Nome da sessão
     *
     * @return bool Sessão expirada ou não
     */
    public function hasExpired(string $name): bool
    {
        if (!$this->exists($name.'_timeout')) {
            return false;
        }

        if (!$this->exists($name.'_created_at')) {
            throw new \LogicException('A sessão < '.$name.'_created_at > não existe.');
        }
        if ($this->get($name.'_created_at') + $this->get($name.'_timeout') < time()) {
            return true;
        }
    }

    /**
     * Usar para apagar um indice do storage.
     *
     * @param string $name
     *
     * @return bool
     */
    public function clear(string $name)
    {
        if ($this->exists($name)) {
            unset($_SESSION[self::PREFIX][$name]);
        }
    }

    /**
     * @param string $message
     * @param string $style
     * @return $this
     */
    public function flash(string $message, string $style = 'info'){

        $this->set($style, $message);

        return $this;
    }


}