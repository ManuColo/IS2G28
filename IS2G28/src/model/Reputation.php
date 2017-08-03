<?php

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Clase que modela reputación de un usuario.
 * 
 * La reputación describe la categoría de un usuario según su puntaje.
 *
 * @author juan
 * @Entity @Table(name="reputations")
 */
class Reputation 
{
  // Reputaciones no editables ni borrables
  const IRRESPONSABLE = 'Irresponsable';
  const OBSERVADOR = 'Observador';
  
  /**
   * Identificador unívoco de la reputación.
   * 
   * @var integer
   * @Id
   * @GeneratedValue
   * @Column(type="integer")
   */
  private $id;
  
  /**
   * Nombre de la reputación.
   * 
   * @var string
   * @Column(type="string", length=30, unique=true)
   */
  private $name;
  
  /**
   * Nombre de la imagen asociada a la reputación.
   * 
   * @var string 
   * @Column(type="string")
   */
  private $image;
  
  /**
   * Puntaje mínimo de la reputación.
   * 
   * @var integer
   * @Column(type="smallint" )
   */
  private $minScore;
  

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return Reputation
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set image
   *
   * @param string $image
   *
   * @return Reputation
   */
  public function setImage($image)
  {
    $this->image = $image;

    return $this;
  }

  /**
   * Get image
   *
   * @return string
   */
  public function getImage()
  {
    return $this->image;
  }

  /**
   * Set minScore
   *
   * @param integer $minScore
   *
   * @return Reputation
   */
  public function setMinScore($minScore)
  {
    $this->minScore = $minScore;

    return $this;
  }

  /**
   * Get minScore
   *
   * @return integer
   */
  public function getMinScore()
  {
    return $this->minScore;
  }
  
  /**
   * Retorna verdadero si es una reputación default del sistema, falso en caso contrario.
   * 
   */
  public function isDefault()
  {
    return $this->getName() == self::IRRESPONSABLE || $this->getName() == self::OBSERVADOR;    
  }
    
  /**
   * Configura las reglas de validacion que se aplican sobre una reputación
   * 
   * @param ClassMetadata $metadata
   */
  public static function loadValidatorMetadata(ClassMetadata $metadata)
  {
    $metadata->addPropertyConstraint('name', new Assert\NotBlank(array(
        'message' => 'Nombre requerido.'
    )));    
    
    $metadata->addPropertyConstraint('image', new Assert\NotBlank(array(
        'message' => 'Imagen requerida.'
    )));
    $metadata->addPropertyConstraint('image', new Assert\Image(array(
        'maxSize' => '1024k',
        'mimeTypesMessage' => 'El archivo no es una imagen valida.',
        'maxSizeMessage' => 'La imagen es demasiado grande.'
    )));    
    
    // Reglas acerca del valor de la propiedad minScore
    $metadata->addPropertyConstraint('minScore', new Assert\NotBlank(array(
        'message' => 'Puntaje mínimo requerido.'
    )));
    $metadata->addPropertyConstraint('minScore', new Assert\Type(array(
        'type' => 'integer',
        'message' => 'El valor {{ value }} no es un puntaje válido. Ingrese un número entero.'
    )));        
    
  }
}
