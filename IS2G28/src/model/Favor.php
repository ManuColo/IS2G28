<?php

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Description of Favor
 *
 * @author juan
 * @Entity @Table(name="favors")
 */
class Favor 
{
  /**
   * @Id @Column(type="integer") @GeneratedValue
   * @var integer 
   */
  protected $id;
  
  /**
   * @Column(type="string")
   * @var string 
   */
  protected $title;
  
  /**
   * @Column(type="string")
   * @var string 
   */
  protected $description;
  
  /**
   * @Column(type="string")
   * @var string 
   */
  protected $photo;
  
  /**
   * @Column(type="string")
   * @var string 
   */
  protected $city;
  
  /**
   * @Column(type="date")
   * @var DateTime 
   */
  protected $deadline;
  
  /**
   * @Column(type="boolean", nullable=true)
   * @var Boolean
   */
  private $unpublished;
  
  /**
   * @Column(type="boolean", nullable=true)
   * @var Boolean
   */
  private $resolved;
  
  /**
   * Dueño o propietario del favor.
   * 
   * @var User Usuario propietario del favor
   * @ManyToOne(targetEntity="User", inversedBy="myFavors")
   * @JoinColumn(name="owner_user_id", referencedColumnName="id", nullable=false)
   */
  private $owner;
  
  /**
   * Postulaciones al favor.
   *
   * @var Collection Coleccion de postulacione(Postulation[])
   * @oneToMany(targetEntity="Postulation", mappedBy="favor")
   */
  private $myPostulations;
  
  /**
   * Preguntas publicadas en el favor.
   *
   * @var Collection Colección de preguntas (Question[])
   * @OneToMany(targetEntity="Question", mappedBy="favor")
   */
  private $questions;
  
  /**
   * Calificación al dueño de la gauchada.
   * 
   * @var Qualification
   * @OneToOne(targetEntity="Qualification")
   * @JoinColumn(name="owner_qualification_id", referencedColumnName="id") 
   */
  private $ownerQualification;
  
  /**
   * Calificación al postulante aceptado de la gauchada
   * 
   * @var Qualification
   * @OneToOne(targetEntity="Qualification")
   * @JoinColumn(name="postulant_qualification_id", referencedColumnName="id") 
   */
  private $postulantQualification;

  /**
   * @Column(type="integer")
   * @var integer
   */
  private $cantApplications;
  
  public function __construct() {
    $this->cantApplications = 0;
    $this->unpublished = False;
    $this->resolved = False;
    $this->myPostulations = new ArrayCollection();
    $this->questions = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }
  
  public function getTitle()
  {
    return $this->title;
  }
  
  public function setTitle($title)
  {
    $this->title = $title;
  }
  
  public function getDescription()
  {
    return $this->description;
  }
  
  public function setDescription($description)
  {
    $this->description = $description;
  }
  
  public function getPhoto()
  {
    return $this->photo;
  }
  
  public function setPhoto($photo)
  {
    $this->photo = $photo;
  }
  
  public function getCity()
  {
    return $this->city;
  }
  
  public function setCity($city)
  {
    $this->city = $city;
  }
  
  public function getDeadline()
  {
    return $this->deadline;
  }
  
  public function setDeadline($deadline)
  {
    $this->deadline = $deadline;
  }
  
  public function getUnpublished()
  {
  	return $this->unpublished;
  }
  
  public function setUnpublished($aBool)
  {
  	$this->unpublished = $aBool;
  }
  
  public function getResolved()
  {
  	return $this->resolved;
  }
  
  public function setResolved($aBool)
  {
  	$this->resolved = $aBool;
  }
  
  public function getOwner()
  {
    return $this->owner;
  }
  
  public function setOwner(User $owner)
  {
    $owner->addMyFavor($this); // Para mantener consistente la relacion bidireccional
    $this->owner = $owner;
  }
  
  /**
   * Agrega la postulación a la coleccion de postulaciones del usuario.
   *
   * @param Postulation $postulation
   */
  public function addMyPostulation(Postulation $postulation) {
  	$this->myPostulations[] = $postulation;
  }

  /**
   * Retonar la coleccion de postulaciones del usuario.
   *
   * @return Colection Coleccion de postulaciones (Postulation[])
   */
  public function getMyPostulations() {
  	return $this->myPostulations;
  }

  /**
   * Configura las reglas de validacion que se aplican sobre un objeto Favor
   * 
   * @param ClassMetadata $metadata
   */
  public static function loadValidatorMetadata(ClassMetadata $metadata)
  {
    $metadata->addPropertyConstraint('title', new Assert\NotBlank(array(
        'message' => 'Titulo requerido.'
    )));    
    $metadata->addPropertyConstraint('description', new Assert\NotBlank(array(
        'message' => 'Descripcion requerida.'
    )));
    
    $metadata->addPropertyConstraint('photo', new Assert\Image(array(
        'maxSize' => '1024k',
        'mimeTypesMessage' => 'El archivo no es una imagen valida.',
        'maxSizeMessage' => 'La imagen es demasiado grande. El tamaño maximo permitido es {{ limit }} {{ suffix }}.'
    )));
    
    $metadata->addPropertyConstraint('city', new Assert\NotBlank(array(
        'message' => 'Ciudad requerida.'
    )));
    
    $metadata->addPropertyConstraint('deadline', new Assert\NotBlank(array(
      'message' => 'Fecha limite requerida'
    )));
    $metadata->addPropertyConstraint('deadline', new Assert\Date(array(
        'message' => 'Fecha limite invalida.'
    )));
    $metadata->addConstraint(new Assert\Callback('validateDeadlineSinceToday', array(
        'groups' => array('Strict')
    )));

    $metadata->setGroupSequence(array('Favor', 'Strict'));

    //$metadata->addPropertyConstraint('deadline', new Assert\GreaterThanOrEqual(new DateTime("today")));
  }
  
  public function setCantApplications($cant){
  	$this->cantApplications = $cant;
  }
    
  public function getCantCredits(){
  	return $this->cantCredits;
  }
  
  public function validateDeadlineSinceToday(ExecutionContextInterface $context)
  {
    $today = new DateTime('today');    
    try {
      $deadline = new DateTime($this->deadline);      
    } catch (Exception $ex) {
      return;      
    }
    
    
    if ($deadline < $today) {
      $context->buildViolation('La fecha limite no puede ser previa a la fecha actual.')
        ->atPath('deadline')
        ->addViolation();
    }
        
  }
  
  

    /**
     * Get cantApplications
     *
     * @return integer
     */
    public function getCantApplications()
    {
        return $this->cantApplications;
    }

    /**
     * Remove myPostulation
     *
     * @param \Postulation $myPostulation
     */
    public function removeMyPostulation(\Postulation $myPostulation)
    {
        $this->myPostulations->removeElement($myPostulation);
    }

    /**
     * Add question
     *
     * @param \Question $question
     *
     * @return Favor
     */
    public function addQuestion(\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \Question $question
     */
    public function removeQuestion(\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
    
    /**
     * Set ownerQualification
     *
     * @param \Qualification $ownerQualification
     *
     * @return Favor
     */
    public function setOwnerQualification(\Qualification $ownerQualification = null)
    {
      $this->ownerQualification = $ownerQualification;

      return $this;
    }

    /**
     * Get ownerQualification
     *
     * @return \Qualification
     */
    public function getOwnerQualification()
    {
      return $this->ownerQualification;
    }

    /**
     * Set postulantQualification
     *
     * @param \Qualification $postulantQualification
     *
     * @return Favor
     */
    public function setPostulantQualification(\Qualification $postulantQualification = null)
    {
      $this->postulantQualification = $postulantQualification;

      return $this;
    }

    /**
     * Get postulantQualification
     *
     * @return \Qualification
     */
    public function getPostulantQualification()
    {
      return $this->postulantQualification;
    }

    /**
     * Retorna true si un favor no esta vencido ni despublicado ni aceptado, false en caso contrario.
     * 
     * @return boolean
     */
    public function isActive()
    {
      $now = new DateTime();
      $today = new DateTime($now->format('Y-m-d'));

      // Falta comprobar que no este despublicado ni que tenga aceptado un postulante
      return $today <= $this->deadline && !$this->unpublished && !$this->resolved;      
    }
    
    public function getAcceptedPostulant()
    {
      foreach ($this->getMyPostulations() as $postulation) {
        if ($postulation->getStatus() === 'Aceptado') {
          $acceptedPostulation = $postulation;
        }        
      }      
      return $acceptedPostulation?$acceptedPostulation->getUser():null;            
    }
}
