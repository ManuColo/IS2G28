<?php

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Clase que representa calificación en un favor (del dueño o del postulante aceptado).
 *
 * @author juan
 * @Entity @Table(name="qualifications")
 */
class Qualification 
{
  const RESULT_POSITIVE = 1;
  const RESULT_NEUTRAL = 0;
  const RESULT_NEGATIVE = -2;


  /**
   * Identificador unívoco de la calificación
   * 
   * @var integer
   * @Id
   * @GeneratedValue
   * @Column(type="integer") 
   */
  private $id;
  
  /**
   * Resultado de la calificación (+1, 0, -2)
   * 
   * @var integer 
   * @Column(type="integer")
   */
  private $result;
  
  /**
   * Comentario de la calificación
   * 
   * @var string
   * @Column(type="string", length=255) 
   */
  private $comment;
  
  /**
   * Instante en que se realizó la calificación
   * 
   * @var DateTime
   * @Column(type="datetime")
   */
  private $createdAt;
    
   
  

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
   * Set result
   *
   * @param integer $result
   *
   * @return Qualification
   */
  public function setResult($result)
  {
    $this->result = $result;

    return $this;
  }

  /**
   * Get result
   *
   * @return integer
   */
  public function getResult()
  {
    return $this->result;
  }

  /**
   * Set comment
   *
   * @param string $comment
   *
   * @return Qualification
   */
  public function setComment($comment)
  {
    $this->comment = $comment;

    return $this;
  }

  /**
   * Get comment
   *
   * @return string
   */
  public function getComment()
  {
    return $this->comment;
  }

  /**
   * Set createdAt
   *
   * @param \DateTime $createdAt
   *
   * @return Qualification
   */
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get createdAt
   *
   * @return \DateTime
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  
  /**
   * Configura las reglas de validacion que se aplican sobre una instancia de Qualification
   * 
   * @param ClassMetadata $metadata
   */
  public static function loadValidatorMetadata(ClassMetadata $metadata)
  {
    $metadata->addPropertyConstraint('result', new Assert\NotNull(array(
        'message' => 'Resultado requerido.'
    )));
    
    $metadata->addPropertyConstraint('comment', new Assert\NotBlank(array(
        'message' => 'Comentario requerido.'
    )));    
    $metadata->addPropertyConstraint('comment', new Assert\Length(array(
        'max' => 255,
        'maxMessage' => 'El comentario no puede exceder los {{ limit }} caracteres.'
    )));
  }
  
  public function __toString()
  {
  	if ($this->getResult() < 0) {
  		return 'Negativa';
  	} elseif ($this->getResult() > 0) {
  		return 'Positiva';
  	} else {
  		return 'Neutral';
  	}
  }
  
}
