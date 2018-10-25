<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/08/2018
 * Time: 01:11
 */

namespace Flexe\Storage;


interface StorageInterface
{

    /**
     * Usar para armazenar um valor no storage.
     *
     * @param string $name Nome do indice para o valor
     * @param $value
     * @param $timeout
     * @return
     */
    public function set(string $name, $value, $timeout);

    /**
     * Usar para resgatar um valor no storage.
     *
     * @param string $name Nome do indice que o valor foi armazenado
     *
     * @return *
     */
    public function get(string $name);

    /**
     * Usar para verificar se um indice existe no storage.
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name): bool;

    /**
     * Usar para apagar um indice do storage.
     *
     * @param string $name
     *
     * @return bool
     */
    public function clear(string $name);

}