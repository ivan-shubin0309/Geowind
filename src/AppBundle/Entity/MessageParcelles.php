<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;

/**
 * Entité MessageParcelles
 * 
 * Représente un message envoyé via l'annuaire
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageParcellesRepository")
 * @Vich\Uploadable
 */
class MessageParcelles
{
    use BlameableTrait;
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Projet
     * 
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="messagesParcelles")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $projet;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="from_mail")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $from;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $replyTo = 'r.ammour@wkn-france.fr';
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="to_mail")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $to;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $object;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $communes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $departements;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $parcelles;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $documentOriginalName = 'document';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="document", fileNameProperty="document")
     */
    private $documentFile;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->object;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getFrom()
    {
        return $this->from;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCommunes()
    {
        return $this->communes;
    }

    public function getDepartements()
    {
        return $this->departements;
    }

    public function getParcelles()
    {
        return $this->parcelles;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setCommunes($communes)
    {
        $this->communes = $communes;
        return $this;
    }

    public function setDepartements($departements)
    {
        $this->departements = $departements;
        return $this;
    }

    public function setParcelles($parcelles)
    {
        $this->parcelles = $parcelles;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     *
     * @param string $document
     * @return \AppBundle\Entity\Message
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $document
     *
     * @return $this
     */
    public function setDocumentFile(File $document = null)
    {
        $this->documentFile = $document;
        if ($document) {
            if ($document instanceof UploadedFile) {
                $this->documentOriginalName = $document->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentOriginalName()
    {
        return $this->documentOriginalName;
    }

    /**
     * @param string $documentOriginalName
     * @return \AppBundle\Entity\Message
     */
    public function setDocumentOriginalName($documentOriginalName)
    {
        $this->documentOriginalName = $documentOriginalName;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * @param DateTime|null $date
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        $this->date = $date;
        return $this;
    }
    
    public function getProjet()
    {
        return $this->projet;
    }

    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }
}
