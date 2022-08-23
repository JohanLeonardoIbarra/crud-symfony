<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document]
class Pedido
{
    #[ODM\Id]
    private $id;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private $user_id;

    #[ODM\Field(type: "int")]
    #[Assert\NotBlank]
    #[Assert\Regex('/^[1-9]+[0-9]*$/', 'Quantity only can be a number',null,true)]
    private $cantidad;

    #[ODM\Field(type: "float")]
    #[Assert\NotBlank]
    #[Assert\Regex('/[+-]?([0-9]*[.])?[0-9]+/', 'Unitary price only can be a number',null,true)]
    private $precio_unitario;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
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
    public function setUserId($user_id): Pedido
    {
        $this->user_id = $user_id;
        return $this;
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
    public function setCantidad($cantidad): Pedido
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * @return array
     */
    public function getPrecioUnitario(): int
    {
        return $this->precio_unitario;
    }

    /**
     * @param array $precio_unitario
     */
    public function setPrecioUnitario($precio_unitario): Pedido
    {
        $this->precio_unitario = $precio_unitario;
        return $this;
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
    public function setNombreProducto($nombre_producto): Pedido
    {
        $this->nombre_producto = $nombre_producto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTotal(): float{
        return $this->precio_unitario*$this->cantidad;
    }
}