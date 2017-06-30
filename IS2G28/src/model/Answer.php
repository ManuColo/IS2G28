<?php

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Clase que representa respuesta a una pregunta de un favor.
 *
 * @author juan
 * @Entity
 * @Table(name="answers")
 */
class Answer 
{
  /**
   * Identificador unívoco de la respuesta.
   * 
   * @var integer
   * @Id @GeneratedValue
   * @Column(type="integer") 
   */
  private $id;
  
  /**
   * Contenido de la respuesta. 
   * 
   * @var string
   * @Column(type="string", length=255) 
   */
  private $content;
  
  /**
   * Instante de publicación de la respuesta.
   * 
   * @var DateTime
   * @Column(type="datetime") 
   */
  private $postedAt;
  
  /**
   * Pregunta a la que corresponde la respuesta.
   * 
   * @var Question
   * @OneToOne(targetEntity="Question", inversedBy="answer")
   * @JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
   */
  private $question;

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
   * Set content
   *
   * @param string $content
   *
   * @return Answer
   */
  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  /**
   * Get content
   *
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Set postedAt
   *
   * @param \DateTime $postedAt
   *
   * @return Answer
   */
  public function setPostedAt($postedAt)
  {
    $this->postedAt = $postedAt;

    return $this;
  }

  /**
   * Get postedAt
   *
   * @return \DateTime
   */
  public function getPostedAt()
  {
    return $this->postedAt;
  }

  /**
   * Set question
   *
   * @param \Question $question
   *
   * @return Answer
   */
  public function setQuestion(\Question $question = null)
  {
    $this->question = $question;

    return $this;
  }

  /**
   * Get question
   *
   * @return \Question
   */
  public function getQuestion()
  {
    return $this->question;
  }
  
  /**
   * Configura las reglas de validacion que se aplican sobre una instancia de Answer
   * 
   * @param ClassMetadata $metadata
   */
  public static function loadValidatorMetadata(ClassMetadata $metadata)
  {
    $metadata->addPropertyConstraint('content', new Assert\NotBlank(array(
        'message' => 'Contenido de la respuesta requerido.'
    )));    
    $metadata->addPropertyConstraint('content', new Assert\Length(array(
        'max' => 255,
        'maxMessage' => 'La respuesta no puede exceder los {{ limit }} caracteres.'
    )));
  }
  
}
