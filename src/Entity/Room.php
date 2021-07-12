<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="Tchats")
     */
    private $occupants;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="tchat")
     */
    private $Messages;

    public function __construct()
    {
        $this->occupants = new ArrayCollection();
        $this->Messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getOccupants(): Collection
    {
        return $this->occupants;
    }

    public function addOccupant(User $occupant): self
    {
        if (!$this->occupants->contains($occupant)) {
            $this->occupants[] = $occupant;
        }

        return $this;
    }

    public function removeOccupant(User $occupant): self
    {
        $this->occupants->removeElement($occupant);

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->Messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->Messages->contains($message)) {
            $this->Messages[] = $message;
            $message->setTchat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->Messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTchat() === $this) {
                $message->setTchat(null);
            }
        }

        return $this;
    }
}
