<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;

/**
 * User entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @Vich\Uploadable
 */
class User implements AdvancedUserInterface, \Serializable
{
    use BlameableTrait;
    use TimestampableTrait;

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MODIFY_ALL = 'ROLE_MODIFY_ALL';
    const ROLE_VIEW_ALL = 'ROLE_VIEW_ALL';

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
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Plain password - Not mapped by doctrine
     *
     * @var string
     */
    private $plainPassword;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $roles;

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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $telephone;

    /**
     * @var ArrayCollection|Departement[]
     *
     * @ORM\ManyToMany(targetEntity="Departement", inversedBy="users")
     */
    private $departements;

    /**
     * @var ArrayCollection|Departement[]
     *
     * @ORM\ManyToMany(targetEntity="Departement")
     * @ORM\JoinTable(name="user_departement_chef_projet")
     */
    private $departementsChefProjet;

    /**
     * @var ArrayCollection|Departement[]
     *
     * @ORM\ManyToMany(targetEntity="Departement")
     * @ORM\JoinTable(name="user_departement_charge_foncier")
     */
    private $departementsChargeFoncier;

    /**
     * @var ArrayCollection|Messagerie[]
     *
     * @ORM\ManyToMany(targetEntity="Messagerie", inversedBy="viewers", cascade={"all"}, orphanRemoval=true)
     */
    private $messageries;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff", fileNameProperty="photo")
     */
    private $photoFile;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled = true;

    /**
     * @var bool
     */
    private $sendCredentials = false;

    /**
     * @var bool
     */
    private $sendSecteurs = false;

    public function __construct()
    {
        $this->roles = [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strtoupper($this->nom) . ' ' . $this->prenom;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return \AppBundle\Entity\User
     */
    function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array_merge($this->roles, ['ROLE_USER']);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * @param array $roles
     * @return \AppBundle\Entity\User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Returns null - salt not implemented (using bcrypt)
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public static function getRolesList()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MODIFY_ALL => 'Tout modifier',
            self::ROLE_VIEW_ALL => 'Tout voir',
        ];
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return \AppBundle\Entity\User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSendCredentials()
    {
        return $this->sendCredentials;
    }

    /**
     * @param bool $sendCredentials
     * @return \AppBundle\Entity\User
     */
    public function setSendCredentials($sendCredentials)
    {
        $this->sendCredentials = $sendCredentials;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSendSecteurs()
    {
        return $this->sendSecteurs;
    }

    /**
     * @param bool $sendSecteurs
     * @return \AppBundle\Entity\User
     */
    public function setSendSecteurs($sendSecteurs)
    {
        $this->sendSecteurs = $sendSecteurs;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * 
     * @param string $nom
     * @return $this
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return $this
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return ArrayCollection|Departement[]
     */
    public function getDepartements()
    {
        return $this->departements;
    }

    /**
     * @param \AppBundle\Entity\Departement $departement
     */
    public function addDepartement(Departement $departement)
    {
        $this->departements[] = $departement;
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $departements
     * @return \AppBundle\Entity\Projet
     */
    public function setDepartements(ArrayCollection $departements)
    {
        $this->departements = $departements;
        return $this;
    }

    /**
     * @return ArrayCollection|Departement[]
     */
    public function getDepartementsChefProjet()
    {
        return $this->departementsChefProjet;
    }

    /**
     * @param \AppBundle\Entity\Departement $departement
     */
    public function addDepartementChefProjet(Departement $departement)
    {
        $this->departementsChefProjet[] = $departement;
        if (!$this->departementsChefProjet->contains($departement)) {
            $this->departementsChefProjet[] = $departement;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $departementsChefProjet
     * @return \AppBundle\Entity\Projet
     */
    public function setDepartementsChefProjet(ArrayCollection $departementsChefProjet)
    {
        $this->departementsChefProjet = $departementsChefProjet;
        return $this;
    }

    /**
     * @return ArrayCollection|Departement[]
     */
    public function getDepartementsChargeFoncier()
    {
        return $this->departementsChargeFoncier;
    }

    /**
     * @param \AppBundle\Entity\Departement $departement
     */
    public function addDepartementChargeFoncier(Departement $departement)
    {
        $this->departementsChargeFoncier[] = $departement;
        if (!$this->departementsChargeFoncier->contains($departement)) {
            $this->departementsChargeFoncier[] = $departement;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $departementsChargeFoncier
     * @return \AppBundle\Entity\Projet
     */
    public function setDepartementsChargeFoncier(ArrayCollection $departementsChargeFoncier)
    {
        $this->departementsChargeFoncier = $departementsChargeFoncier;
        return $this;
    }

    /**
     * @return ArrayCollection|Messagerie[]
     */
    public function getMessageries()
    {
        return $this->messageries;
    }

    /**
     * @param \AppBundle\Entity\Messagerie $messagerie
     */
    public function addMessagerie(Messagerie $messagerie)
    {
        if (!$this->messageries->contains($messagerie)) {
            $this->messageries[] = $messagerie;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $messageries
     * @return \AppBundle\Entity\Projet
     */
    public function setMessageries(ArrayCollection $messageries)
    {
        $this->messageries = $messageries;
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
     * @return \AppBundle\Entity\User
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
        return $this;
    }
}
