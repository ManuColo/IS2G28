<?php


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
   * @Column(type="integer")
   * @var integer
   */
  private $cantApplications;
  
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
  
  public function setCantApplications($cant){
  	$this->cantApplications = $cant;
  }
    
  public function getCantCredits(){
  	return $this->cantCredits;
  }
  
}
