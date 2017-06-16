<?php
/**
 * Description of Postulation
 *
 * @author manuel
 * @Entity @Table(name="postulations")
 */

Class Postulation {
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 * @var integer
	 */
	private $id;
	
	/**
	* Usuario postulado.
	* 
	* @var User Usuario postulado al favor
	* @ManyToOne(targetEntity="User", inversedBy="myPostulations")
	* @JoinColumn(name="userId", referencedColumnName="id", nullable=false)
	*/
	private $user;
	
	/**
	* Favor al que se refiere la postulación.
	* 
	* @var Favor Favor origen de la postulación
	* @ManyToOne(targetEntity="Favor", inversedBy="myPostulations")
	* @JoinColumn(name="favorId", referencedColumnName="id", nullable=false)
	*/
	private $favor;
	
	/**
	 * @Column(type="string",nullable=true)
	 * @var string
	 */
	private $comment;
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setUser(User $user){
		$user->addPostulation($this);
		$this->user = $user;
	}
	
	public function setFavor($favor){
		$favor->addPostulation($this);
		$this->favor = $favor;
	}
	
	public function setComment($aComment){
		$this->comment = $aComment;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function getFavor(){
		return $this->favor;
	}
	
	public function getComment(){
		return $this->comment;
	}
	
	public function __construct()
	{
		$this->comment = null;
	}
}