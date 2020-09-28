<?php

namespace App\Entity;

use App\Repository\UrlShortRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Env;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass=UrlShortRepository::class)
 */
class UrlShort implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $crypt;

    /**
     * @ORM\Column(type="integer")
     */
    private $clicks;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="urlShorts")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCrypt(): ?string
    {
        return $this->crypt;
    }

    public function setCrypt(string $crypt): self
    {
        $this->crypt = $crypt;

        return $this;
    }

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function jsonSerialize()
    {
        $userName = is_null($this->getUser()) ? NULL : $this->getUser()->getNome();
        $short = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->getCrypt();
        return [
            'original' => $this->getUrl(),
            'short' => $short,
            'createdAt' => $this->getCreatedat(),
            'user' => $userName,
            'stats' => ['clicks' => $this->getClicks()]
        ];
    }
}
