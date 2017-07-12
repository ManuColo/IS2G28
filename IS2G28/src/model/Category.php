<?php
/**
 * Description of Category
 *
 * @author manuel
 * @Entity @Table(name="categories")
 */

Class Category {
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
	* Favores pertenecientes a la categoría.
	*
	* @var Collection Coleccion de favores de la categoría(Favor[])
	* @OneToMany(targetEntity="Favor", mappedBy="category")
	*/
	private $myFavors;
	
	public function __construct() {
		$this->myFavors = new ArrayCollection();
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	/**
	 * Agrega el favor dado a la coleccion de favores la categoría.
	 *
	 * @param Favor $favor
	 */
	public function addMyFavor(Favor $favor) {
		$this->myFavors[] = $favor;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Retonar la coleccion de favores pertenecientes a la categoría.
	 *
	 * @return Colecction Coleccion de favores (Favor[])
	 */
	public function getMyFavors() {
		return $this->myFavors;
	}
	
}