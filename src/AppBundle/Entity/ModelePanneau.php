<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use JsonSerializable;

/**
 * ModelePanneau entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @UniqueEntity(fields={"nom", "technique", "puissance"})
 */
class ModelePanneau implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $technique;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="puissance", nullable=true)
     */
    private $puissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $longueur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $largeur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $epaisseur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $poids;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
        return $this;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    }

    /**
     * @return string
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     *
     * @param string $technique
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setTechnique($technique)
    {
        $this->technique = $technique;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissance()
    {
        return $this->puissance;
    }

    /**
     *
     * @param string $puissance
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     *
     * @param string $longueur
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
        return $this;
    }

    /**
     * @return string
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     *
     * @param string $largeur
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * @return string
     */
    public function getEpaisseur()
    {
        return $this->epaisseur;
    }

    /**
     *
     * @param string $epaisseur
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setEpaisseur($epaisseur)
    {
        $this->epaisseur = $epaisseur;
        return $this;
    }

    /**
     * @return string
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     *
     * @param string $poids
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom ? $this->nom : 'Modèle'.$this->id;
    }

    public function cloneThis(ModelePanneau $modelePanneau)
    {
        $this->nom = $modelePanneau->getNom();
        $this->marque = $modelePanneau->getMarque();
        $this->technique = $modelePanneau->getTechnique();
        $this->pays = $modelePanneau->getPays();
        $this->puissance = $modelePanneau->getPuissance();
        $this->longueur = $modelePanneau->getLongueur();
        $this->largeur = $modelePanneau->getLargeur();
        $this->epaisseur = $modelePanneau->getEpaisseur();
        $this->poids = $modelePanneau->getPoids();
    }

    public function jsonSerialize()
    {
        return array(
            // 'id' => $this->id,
            // 'Modèle' => $this->nom,
            // 'Marque'=> $this->marque,
            // 'Origine'=> $this->pays,
            'Technique'=> $this->technique,
            'Puissance <span style="color:black;">(Wc)</span>'=> $this->puissance,
            'Longueur <span style="color:black;">(mm)</span>'=> $this->longueur,
            'Largeur <span style="color:black;">(mm)</span>'=> $this->largeur,
            // 'Epaisseur <span style="color:black;">(mm)</span>'=> $this->epaisseur,
            // 'Poids <span style="color:black;">(kg)</span>'=> $this->poids,
        );
    }
}
