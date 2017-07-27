<?php

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
}
