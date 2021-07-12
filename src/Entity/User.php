<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="speaker")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Room::class, mappedBy="occupants")
     */
    private $Tchats;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->Tchats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSpeaker($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSpeaker() === $this) {
                $message->setSpeaker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getTchats(): Collection
    {
        return $this->Tchats;
    }

    public function addTchat(Room $tchat): self
    {
        if (!$this->Tchats->contains($tchat)) {
            $this->Tchats[] = $tchat;
            $tchat->addOccupant($this);
        }

        return $this;
    }

    public function removeTchat(Room $tchat): self
    {
        if ($this->Tchats->removeElement($tchat)) {
            $tchat->removeOccupant($this);
        }

        return $this;
    }
}
