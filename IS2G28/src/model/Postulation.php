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
	private $userId;
	
	/**
	* Favor al que se refiere la postulación.
	* 
	* @var Favor Favor origen de la postulación
	* @ManyToOne(targetEntity="Favor", inversedBy="myPostulations")
	* @JoinColumn(name="favorId", referencedColumnName="id", nullable=false)
	*/
	private $favorId;
	
	/**
	 * @Column(type="string",nullable=true)
	 * @var string
	 */
	private $comment;
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setUserId($userId){
		$this->userId = $userId;
	}
	
	public function setFavorId($favorId){
		$this->favorId = $favorId;
	}
	
	public function setComment($aComment){
		$this->comment = $aComment;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getUserId(){
		return $this->userId;
	}
	
	public function getFavorId(){
		return $this->favorId;
	}
	
	public function getComment(){
		return $this->comment;
	}
	
	public function __construct()
	{
		$this->comment = null;
	}
}