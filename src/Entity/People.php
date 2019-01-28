<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeopleRepository")
 */
class People
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $peopleId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="people")
     */
    private $userId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeopleId(): ?int
    {
        return $this->peopleId;
    }

    public function setPeopleId(int $peopleId): self
    {
        $this->peopleId = $peopleId;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId[] = $userId;
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->userId->contains($userId)) {
            $this->userId->removeElement($userId);
        }

        return $this;
    }
}
