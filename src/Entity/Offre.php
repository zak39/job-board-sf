<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Écrire quelques mots sur la description de votre offre.')]
    private ?string $description = null;

    #[Assert\Positive(message: 'Il faut que le salaire soit possitif.')]
    #[Assert\NotBlank(message: 'Il faut définir un salaire.')]
    #[Assert\Range([
        'min' => 1000.00,
        'max' => 9999.99,
        'notInRangeMessage' => 'Le salaire doit être entre {{ min }} € et {{ max }} € pour être valide.',
    ])]
    #[Assert\Regex(pattern: '/^[0-9]{1,5}(\.[0-9]{2})?$/', message: 'Entrez un salaire valide : 5 chiffres max avant le point, 2 chiffres max après.')]
    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $salaire = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'offres')]
    private Collection $tags;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[Assert\NotBlank(message: 'Il faut choisir une entreprise.')]
    private ?Entreprise $entreprise = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(?string $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
