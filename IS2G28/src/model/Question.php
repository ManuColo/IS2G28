<?php

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Clase que representa pregunta de un favor.
 *
 * @author juan
 * @Entity @Table(name="questions")
 */
class Question 
{
  /**
   * Identificador unívoco de la pregunta.
   * 
   * @var integer 
   * @Id @Column(type="integer") @GeneratedValue
   */
  private $id;
  
  /**
   * Contenido de la pregunta.
   * 
   * @var string 
   * @Column(type="string", length=255)
   */
  private $content;
  
  /**
   * Instante en que se realizó la pregunta
   * 
   * @var DateTime
   * @Column(type="datetime")
   */
  private $postedAt;
  
  /**
   * Favor al que corresponde la pregunta.
   * 
   * @var Favor 
   * @ManyToOne(targetEntity="Favor", inversedBy="questions")
   * @JoinColumn(name="favor_id", referencedColumnName="id", nullable=false)
   */
  private $favor;
  
  /**
   * Usuario que realizó la pregunta.
   * 
   * @var User 
   * @ManyToOne(targetEntity="User")
   * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
   */
  private $author;
  
  /**
   * Respuesta de la pregunta
   * 
   * @var Answer
   * @OneToOne(targetEntity="Answer", mappedBy="question") 
   */
  private $answer;
  

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
   * @return Question
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
   * @return Question
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
   * Set favor
   *
   * @param \Favor $favor
   *
   * @return Question
   */
  public function setFavor(\Favor $favor = null)
  {
      $this->favor = $favor;

      return $this;
  }

  /**
   * Get favor
   *
   * @return \Favor
   */
  public function getFavor()
  {
      return $this->favor;
  }

  /**
   * Set author
   *
   * @param \User $author
   *
   * @return Question
   */
  public function setAuthor(\User $author = null)
  {
      $this->author = $author;

      return $this;
  }

  /**
   * Get author
   *
   * @return \User
   */
  public function getAuthor()
  {
      return $this->author;
  }

  /**
   * Set answer
   *
   * @param \Answer $answer
   *
   * @return Question
   */
  public function setAnswer(\Answer $answer = null)
  {
    $this->answer = $answer;

    return $this;
  }

  /**
   * Get answer
   *
   * @return \Answer
   */
  public function getAnswer()
  {
    return $this->answer;
  }
  
   /**
   * Configura las reglas de validacion que se aplican sobre una instancia de Question
   * 
   * @param ClassMetadata $metadata
   */
  public static function loadValidatorMetadata(ClassMetadata $metadata)
  {
    $metadata->addPropertyConstraint('content', new Assert\NotBlank(array(
        'message' => 'Contenido de la pregunta requerido.'
    )));    
    $metadata->addPropertyConstraint('content', new Assert\Length(array(
        'max' => 255,
        'maxMessage' => 'La pregunta no puede exceder los {{ limit }} caracteres.'
    )));
  }
  
}
