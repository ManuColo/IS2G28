<?php

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
		
	public function getCantApplications(){
		return $this->cantApplications;
	}
	
	public function encryptPassword($password,$salt=''){
		return hash("sha256",$salt . $password);
	}
	
	public function generateSalt(){
		return '$2y$11$'.substr(md5(uniqid(rand(),true)), 0, 22);
	}
	
}
?>