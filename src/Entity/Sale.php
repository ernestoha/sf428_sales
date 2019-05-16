<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaleRepository")
 * @ORM\Table(name="sales")
 */
class Sale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    // @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="sales")
    
    /**
     * 
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $product;

    /**
     * @Assert\Range(min=0.01, max=100.00)
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getProduct(): ?string //?string - Product
    {
        return $this->product;
    }

    public function setProduct(?string $product): self // (?string $product) - (?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = number_format($amount, 2);

        return $this;
    }
}
