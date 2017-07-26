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
   * @Column(type="integer" )
   */
  private $minScore;
}
