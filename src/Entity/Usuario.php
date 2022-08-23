<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[UniqueEntity("email")]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull]
    #[Assert\Regex('/\d/', 'Your name cannot contain a number',null,false)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull]
    #[Assert\Regex('/\d/', 'Your surname cannot contain a number',null,false)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    #[Assert\NotNull]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type:"string", columnDefinition:"ENUM('hombre', 'mujer')")]
    #[Assert\NotNull]
    #[Assert\Choice(choices: ["Hombre", "Mujer"])]
    private ?string $sexo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getSexoDetallado(): string
    {
        return ($this->sexo == "Hombre")? "Soy un hombre": "Soy una mujer";
    }

    public function getFullName(): string{
        return $this->getNombre()." ".$this->getApellido();
    }
}
