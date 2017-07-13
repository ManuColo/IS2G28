<?php
use Doctrine\DBAL\Types\FloatType;

/**
 * Description of Credit
 *
 * @author manuel
 * @Entity @Table(name="credits")
 */

Class Credit {
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 * @var integer
	 */
	private $id;
	
	/**
	 * @Column(type="date")
	 * @var DateTime 
	 */
	private $operationDate;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantidad;
	
	/**
	 * @Column(type="float")
	 * @var FloatType
	 */
	private $amount;
	
	/**
	* Usuario que compra el credito.
	* 
	* @var User Usuario propietario del credito
	* @ManyToOne(targetEntity="User", inversedBy="myCredits")
	* @JoinColumn(name="userId", referencedColumnName="id", nullable=false)
	*/
	private $userId;
	
	public function __construct() {
		$this->amount = 30.00;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setOperationDate($date){
		$this->operationDate= $date;
	}
	
	public function setCantidad($cantidad){
		$this->cantidad = $cantidad;
	}
	
	public function setAmount($amount){
		$this->amount = $amount;
	}
	
	public function setUserId($id){
		$this->userId = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getOperationDate(){
		return $this->operationDate;
	}
	
	public function getCantidad(){
		return $this->cantidad;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function getUserId(){
		return $this->userId;
	}

}
