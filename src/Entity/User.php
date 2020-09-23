<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="city", type="string", length=30, nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Attempt::class, mappedBy="user", orphanRemoval=true)
     */
    private $attempts;

    /**
     * @ORM\Column(type="json")
     */
    private $profile = [];

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $apiToken;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $apiTokenValidUntil;

    public function __construct()
    {
        $this->attempts = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Collection|Attempt[]
     */
    public function getAttempts(): Collection
    {
        return $this->attempts;
    }

    public function addAttempt(Attempt $attempt): self
    {
        if (!$this->attempts->contains($attempt)) {
            $this->attempts[] = $attempt;
            $attempt->setUser($this);
        }

        return $this;
    }

    public function removeAttempt(Attempt $attempt): self
    {
        if ($this->attempts->contains($attempt)) {
            $this->attempts->removeElement($attempt);
            // set the owning side to null (unless already changed)
            if ($attempt->getUser() === $this) {
                $attempt->setUser(null);
            }
        }

        return $this;
    }

    public function getProfile(): array
    {
        return $this->profile;
    }

    public function setProfile(array $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getApiTokenValidUntil(): ?int
    {
        return $this->apiTokenValidUntil;
    }

    public function setApiTokenValidUntil(?int $apiTokenValidUntil): self
    {
        $this->apiTokenValidUntil = $apiTokenValidUntil;

        return $this;
    }
    
    public function getSalt()
    {
        return '';
    }


    public function eraseCredentials()
    {    
    }
    
    public function getRoles(): array
    {
        return [];
    }
    
    public function getUsername()
    {
        return $this->login;
    }
}
