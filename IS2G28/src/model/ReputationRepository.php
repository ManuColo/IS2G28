<?php

use Doctrine\ORM\EntityRepository;

/**
 * Repositorio específico que agrupa las consultas basadas en la tabla de reputaciones.
 *
 * @author juan
 */
class ReputationRepository extends EntityRepository
{
  /**
   * Retorna la reputación asociada al puntaje dado.
   * 
   * @param integer $score
   * @return Reputation
   */
  public function getReputationFromScore($score)
  {
    $qb = $this->_em->createQueryBuilder();
    
    $qb
      ->select('r')      
      ->from('Reputation', 'r')
      ->where($qb->expr()-> gte(
        $qb->expr()->diff($score, 'r.minScore'), 
        0
      ))
      ->orderBy('r.minScore', 'DESC')
      ->setMaxResults(1)
    ;
    
    return $qb->getQuery()->getSingleResult();
    //return $qb->getQuery()->getResult();    
  }
}
