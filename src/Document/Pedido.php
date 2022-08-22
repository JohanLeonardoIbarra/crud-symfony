<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class User
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $user_id;

    /** @ODM\Field(type="string") */
    private $cantidad;

    /** @ODM\Field(type="float") */
    private $precio_unitario = [];

    /** @ODM\Field(type="string") */
    private $nombre_producto;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return array
     */
    public function getPrecioUnitario(): array
    {
        return $this->precio_unitario;
    }

    /**
     * @param array $precio_unitario
     */
    public function setPrecioUnitario(array $precio_unitario): void
    {
        $this->precio_unitario = $precio_unitario;
    }

    /**
     * @return mixed
     */
    public function getNombreProducto()
    {
        return $this->nombre_producto;
    }

    /**
     * @param mixed $nombre_producto
     */
    public function setNombreProducto($nombre_producto): void
    {
        $this->nombre_producto = $nombre_producto;
    }
}