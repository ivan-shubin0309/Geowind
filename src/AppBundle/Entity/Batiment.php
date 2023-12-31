<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Batiment entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BatimentRepository")
 * @Vich\Uploadable
 */
class Batiment
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $pans;

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
    private $faitage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="surface_sol", nullable=true)
     */
    private $surfaceSol;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $charge;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $couverture;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $bardage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $ossature;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $charpente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photoOriginalName = 'photo';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff", fileNameProperty="photo")
     */
    private $photoFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="livraison", nullable=true)
     */
    private $livraison;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="injection", nullable=true)
     */
    private $injection;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="transfo", nullable=true)
     */
    private $transfo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="document_urbanisme", nullable=true)
     */
    private $documentUrbanisme;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="etat_urbanisme", nullable=true)
     */
    private $etatUrbanisme;

    /**
     * @var array
     *
     * @ORM\Column(type="array", name="document_energie", nullable=true)
     */
    private $documentEnergie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="etat_energie", nullable=true)
     */
    private $etatEnergie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $zonage;

    /**
     * @var ArrayCollection|Toiture[]
     *
     * @ORM\OneToMany(targetEntity="Toiture", mappedBy="batimentExistant", cascade={"all"}, orphanRemoval=true)
     */
    private $toitures;

    /**
     * @var Projet
     *
     * @ORM\OneToOne(targetEntity="Projet", mappedBy="batimentExistant")
     */
    private $projet;

    public function __construct()
    {
        $this->toitures = new ArrayCollection();
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
    public function getPans()
    {
        return $this->pans;
    }

    /**
     * @param string $pans
     * @return \AppBundle\Entity\Batiment
     */
    public function setPans($pans)
    {
        $this->pans = $pans;
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
     * @param string $longueur
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * @return string
     */
    public function getFaitage()
    {
        return $this->faitage;
    }

    /**
     *
     * @param string $faitage
     * @return \AppBundle\Entity\Batiment
     */
    public function setFaitage($faitage)
    {
        $this->faitage = $faitage;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceSol()
    {
        return $this->surfaceSol;
    }

    /**
     *
     * @param string $surfaceSol
     * @return \AppBundle\Entity\Batiment
     */
    public function setSurfaceSol($surfaceSol)
    {
        $this->surfaceSol = $surfaceSol;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     *
     * @param string $charge
     * @return \AppBundle\Entity\Batiment
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;
        return $this;
    }

    /**
     * @return string
     */
    public function getCouverture()
    {
        return $this->couverture;
    }

    /**
     *
     * @param string $couverture
     * @return \AppBundle\Entity\Batiment
     */
    public function setCouverture($couverture)
    {
        $this->couverture = $couverture;
        return $this;
    }

    /**
     * @return string
     */
    public function getBardage()
    {
        return $this->bardage;
    }

    /**
     *
     * @param string $bardage
     * @return \AppBundle\Entity\Batiment
     */
    public function setBardage($bardage)
    {
        $this->bardage = $bardage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOssature()
    {
        return $this->ossature;
    }

    /**
     *
     * @param string $ossature
     * @return \AppBundle\Entity\Batiment
     */
    public function setOssature($ossature)
    {
        $this->ossature = $ossature;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharpente()
    {
        return $this->charpente;
    }

    /**
     *
     * @param string $charpente
     * @return \AppBundle\Entity\Batiment
     */
    public function setCharpente($charpente)
    {
        $this->charpente = $charpente;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     *
     * @param string $photo
     * @return \AppBundle\Entity\Batiment
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo
     *
     * @return $this
     */
    public function setPhotoFile(File $photo = null)
    {
        $this->photoFile = $photo;
        if ($photo) {
            if ($photo instanceof UploadedFile) {
                $this->photoOriginalName = $photo->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoOriginalName()
    {
        return $this->photoOriginalName;
    }

    /**
     * @param string $photoOriginalName
     * @return \AppBundle\Entity\Batiment
     */
    public function setPhotoOriginalName($photoOriginalName)
    {
        $this->photoOriginalName = $photoOriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     *
     * @param string $livraison
     * @return \AppBundle\Entity\Batiment
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;
        return $this;
    }

    /**
     * @return string
     */
    public function getInjection()
    {
        return $this->injection;
    }

    /**
     *
     * @param string $injection
     * @return \AppBundle\Entity\Batiment
     */
    public function setInjection($injection)
    {
        $this->injection = $injection;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransfo()
    {
        return $this->transfo;
    }

    /**
     *
     * @param string $transfo
     * @return \AppBundle\Entity\Batiment
     */
    public function setTransfo($transfo)
    {
        $this->transfo = $transfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentUrbanisme()
    {
        return $this->documentUrbanisme;
    }

    /**
     *
     * @param string $documentUrbanisme
     * @return \AppBundle\Entity\Batiment
     */
    public function setDocumentUrbanisme($documentUrbanisme)
    {
        $this->documentUrbanisme = $documentUrbanisme;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtatUrbanisme()
    {
        return $this->etatUrbanisme;
    }

    /**
     *
     * @param string $etatUrbanisme
     * @return \AppBundle\Entity\Terrain
     */
    public function setEtatUrbanisme($etatUrbanisme)
    {
        $this->etatUrbanisme = $etatUrbanisme;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentEnergie()
    {
        return $this->documentEnergie;
    }

    /**
     *
     * @param string $documentEnergie
     * @return \AppBundle\Entity\Terrain
     */
    public function setDocumentEnergie($documentEnergie)
    {
        $this->documentEnergie = $documentEnergie;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtatEnergie()
    {
        return $this->etatEnergie;
    }

    /**
     *
     * @param string $etatEnergie
     * @return \AppBundle\Entity\Terrain
     */
    public function setEtatEnergie($etatEnergie)
    {
        $this->etatEnergie = $etatEnergie;
        return $this;
    }

    /**
     * @return string
     */
    public function getZonage()
    {
        return $this->zonage;
    }

    /**
     *
     * @param string $zonage
     * @return \AppBundle\Entity\Batiment
     */
    public function setZonage($zonage)
    {
        $this->zonage = $zonage;
        return $this;
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @return ArrayCollection|Toiture[]
     */
    public function getToitures()
    {
        return $this->toitures;
    }

    /**
     * @param ArrayCollection $toitures
     * @return \AppBundle\Entity\Batiment
     */
    public function setToitures(ArrayCollection $toitures)
    {
        $this->toitures = $toitures;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Toiture $toiture
     */
    public function addToiture(Toiture $toiture)
    {
        if (!$this->toitures->contains($toiture)) {
            $toiture->setBatimentExistant($this);
            $this->toitures->add($toiture);
        }
    }

    /**
     * @param \AppBundle\Entity\Toiture $toiture
     */
    public function removeToiture(Toiture $toiture)
    {
        $this->toitures->removeElement($toiture);
    }
    
    /**
     * @return array
     */
    public static function getChargeList()
    {
        return [
            'verifier' => 'Vérifier',
            'solide'=> 'Solide',
            'faible'=> 'Faible'
        ];
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\Batiment
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    public function isNotEmpty()
    {
        if($this->pans || $this->longueur || $this->largeur || $this->faitage || $this->surfaceSol || $this->charge || $this->zonage || $this->documentUrbanisme || !$this->toitures->isEmpty())
            return true;
        else return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom ? $this->nom : 'Modèle'.$this->id;
    }
}
