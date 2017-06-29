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
   * @Column(type="integer")
   * @var integer
   */
  private $cantApplications;
  
  public function __construct() {
    $this->cantApplications = 0;
    $this->unpublished = False;
    $this->resolved = False;
    $this->myPostulations = new ArrayCollection();
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
  
  
}