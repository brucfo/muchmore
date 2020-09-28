<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $senha;

    /**
     * @ORM\OneToMany(targetEntity=UrlShort::class, mappedBy="user")
     */
    private $urlShorts;

    public function __construct()
    {
        $this->urlShorts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail()
        ];
    }

    /**
     * @return Collection|UrlShort[]
     */
    public function getUrlShorts(): Collection
    {
        return $this->urlShorts;
    }

    public function addUrlShort(UrlShort $urlShort): self
    {
        if (!$this->urlShorts->contains($urlShort)) {
            $this->urlShorts[] = $urlShort;
            $urlShort->setUser($this);
        }

        return $this;
    }

    public function removeUrlShort(UrlShort $urlShort): self
    {
        if ($this->urlShorts->contains($urlShort)) {
            $this->urlShorts->removeElement($urlShort);
            // set the owning side to null (unless already changed)
            if ($urlShort->getUser() === $this) {
                $urlShort->setUser(null);
            }
        }

        return $this;
    }
}
