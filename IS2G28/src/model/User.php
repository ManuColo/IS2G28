<?php

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of User
 *
 * @author manuel
 * @Entity @Table(name="users")
 */

Class User {
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 * @var integer
	 */
	private $id;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $name;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $lastname;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $phone;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $mail;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $pass;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $salt;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $photo;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantCredits;
    
	/**
	 * @Column(type="integer",nullable=true)
	 * @var integer
	 */
	private $reputation;
	
	/**
   * Creditos comprados por el usuario.
   *
   * @var Collection Coleccion de creditos comprados(Credit[])
   * @OneToMany(targetEntity="Credit", mappedBy="userId")
   */
  private $myCredits;
    
  /**
   * Favores publicados por el usuario.
   * 
   * @var Collection Coleccion de favores publicados(Favor[])
   * @OneToMany(targetEntity="Favor", mappedBy="owner")
   */
  private $myFavors;
  
  /**
   * Postulaciones del usuario.
   *
   * @var Collection Coleccion de postulacione(Postulation[])
   * @oneToMany(targetEntity="Postulation", mappedBy="user")
   */
  private $myPostulations;
  
  /**
   * @Column(type="boolean", nullable=true)
   * @var Boolean
   */
  private $isAdmin;
  
  public function __construct() {
  	$this->photo = '';
  	$this->cantCredits = 1;
    $this->reputation = 0;
    $this->myFavors = new ArrayCollection();
    $this->myCredits = new ArrayCollection();
    $this->myPostulations = new ArrayCollection();
    $this->isAdmin = False;
  }
  
  /**
   * Retorna una representacion como string de una instancia de la clase.
   * 
   * Este metodo permite indicar como se debe comportar un objeto de la clase cuando se lo trata
   * como un string, por ejemplo al hacer echo $user.
   * 
   * @return string Representacion textual del objeto
   */
  public function __toString() 
  {
    return $this->getName() . ' ' . $this->getLastname();
  }

  public function setId($id){
		$this->id = $id;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setLastname($lastname){
		$this->lastname = $lastname;
	}
	
	public function setPhone($phone){
		$this->phone = $phone;
	}
	
	public function setMail($mail){
		$this->mail = $mail;
	}
	
	public function setPass($pass){
		$this->pass = $pass;
	}
	
	public function setSalt($salt){
		$this->salt = $salt;
	}
	
	public function setPhoto($photo){
		$this->photo = $photo;
	}
	
	public function setCantCredits($cant){
		$this->cantCredits = $cant;
	}
	
	public function setReputation($cant){
		$this->reputation = $cant;
	}
  
	/**
	* Agrega el favor dado a la coleccion de favores pedidos por el usuario.
	* 
	* @param Favor $favor
	*/
	public function addMyFavor(Favor $favor) {
		$this->myFavors[] = $favor;    
	}
  
	/**
	* Agrega el credito dado a la coleccion de creditos comprados por el usuario.
	*
	* @param Credit $credit
	*/
	public function addMyCredit(Credit $credit) {
		$this->myCredits[] = $credit;
	}
	
	/**
	 * Agrega la postulación a la coleccion de postulaciones del usuario.
	 *
	 * @param Postulation $postulation
	 */
	public function addMyPostulation(Postulation $postulation) {
		$this->myPostulations[] = $postulation;
	}
	
	public function setIsAdmin($aBool){
		$this->isAdmin = $aBool;
	}

	public function getId(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getLastname(){
		return $this->lastname;
	}
	
	public function getPhone(){
		return $this->phone;
	}
	
	public function getMail(){
		return $this->mail;
	}
	
	public function getPass(){
		return $this->pass;
	}
	
	public function getSalt(){
		return $this->salt;
	}
	
	public function getPhoto(){
		return $this->photo;
	}
		
	public function getCantCredits(){
		return $this->cantCredits;
	}
	
	public function getReputation(){
		return $this->reputation;
	}
  
	/**
	* Retonar la coleccion de favores pedidos por el usuario.
	* 
	* @return Colecction Coleccion de favores (Favor[])
	*/
	public function getMyFavors() {
		return $this->myFavors;
	}

	/**
	 * Retonar la coleccion de creditos comprados por el usuario.
	 *
	 * @return Colection Coleccion de creditos (Credit[])
	 */
	public function getMyCredits() {
		return $this->myCredits;
	}

	/**
	 * Retonar la coleccion de postulaciones del usuario.
	 *
	 * @return Colection Coleccion de postulaciones (Postulation[])
	 */
	public function getMyPostulations() {
		return $this->myPostulations;
	}
	
	public function getIsAdmin(){
		return $this->isAdmin;
	}

	public function encryptPassword($password,$salt=''){
		return hash("sha256",$salt . $password);
	}
	
	public function generateSalt(){
		return '$2y$11$'.substr(md5(uniqid(rand(),true)), 0, 22);
	}
	
	public function discountCredits($aCant=1){
		if ($aCant > 1) {
			$this->cantCredits-$aCant;
		} else {
			$this->cantCredits--;
		}
	}
	
	public function addCredits($aCant=1){
		if ($aCant > 1) {
			$this->cantCredits+$aCant;
		} else {
			$this->cantCredits++;
		}
	}
  
  /**
   * Retorna true si el usuario tiene al menos 1 credito, false en caso contrario.
   * 
   * @return boolean
   */
  public function hasCredits() {
    return $this->cantCredits > 0;    
  }
  
  public function printReputation(){    
  	if ($this->reputation > 50) {
  		return "Dios";
  	} elseif ($this->reputation > 20) {
  		return "Nobleza Gaucha";
  	} elseif ($this->reputation > 10) {
  		return "Tipazo";
  	} elseif ($this->reputation > 5) {
  		return "Gran Tipo";
  	} elseif ($this->reputation > 0) {
  		return "Buen Tipo";
  	} elseif ($this->reputation == 0) {
  		return "Observador";
  	} elseif ($this->reputation < 0) {
  		return "Irresponsable";
  	} else {
  		return "Observador";
  	}
  }
  
  public static function loadValidatorMetadata(ClassMetadata $metadata){
  	$metadata->addPropertyConstraint('photo', new Assert\Image(array(
  			'maxSize' => '1024k',
  			'mimeTypesMessage' => 'El archivo no es una imagen valida.',
  			'maxSizeMessage' => 'La imagen es demasiado grande. El tamaño maximo permitido es {{ limit }} {{ suffix }}.'
  	)));
  	$metadata->setGroupSequence(array('User', 'Strict'));
  }

    /**
     * Remove myCredit
     *
     * @param \Credit $myCredit
     */
    public function removeMyCredit(\Credit $myCredit)
    {
        $this->myCredits->removeElement($myCredit);
    }

    /**
     * Remove myFavor
     *
     * @param \Favor $myFavor
     */
    public function removeMyFavor(\Favor $myFavor)
    {
        $this->myFavors->removeElement($myFavor);
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
}
