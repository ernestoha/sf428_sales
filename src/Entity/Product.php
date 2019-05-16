<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
/*
insert into product (productname) values ('Mobile Phone');
insert into product (productname) values ('SIM Card');
insert into product (productname) values ('Router');
insert into product (productname) values ('Server');
*/
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $idproduct;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $productname;

    /*
     * @ORM\OneToMany(targetEntity="App\Entity\Sale", mappedBy="product")
     
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }
*/

    /**
     * @return Collection|Sale[]
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }


    public function getIdproduct(): ?int
    {
        return $this->idproduct;
    }

    public function setIdproduct(int $idproduct): self
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    public function getProductname(): ?string
    {
        return $this->productname;
    }

    public function setProductname(?string $productname): self
    {
        $this->productname = $productname;

        return $this;
    }


}
