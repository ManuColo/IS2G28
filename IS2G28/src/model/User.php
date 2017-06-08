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
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantCredits;
    
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
  
  public function __construct() 
  {
  	$this->cantCredits = 1;
    $this->myFavors = new ArrayCollection();
    $this->myCredits = new ArrayCollection();
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
	
	public function setCantCredits($cant){
		$this->cantCredits = $cant;
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
		
	public function getCantCredits(){
		return $this->cantCredits;
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
	 * @return Colecction Coleccion de creditos (Credit[])
	 */
	public function getMyCredits() {
		return $this->myCredits;
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
	
}
?>