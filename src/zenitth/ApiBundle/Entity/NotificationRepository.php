<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository
{

	public function getMine($userId) {
		$qb = $this->getEntityManager()->createQueryBuilder();
        $qb->add('select', 'n')
            ->add('from', 'zenitthApiBundle:Notification n')
            ->where('n.userTo = :id')
            ->andwhere('n.isRead = false')
            ->orderBy('n.createdAt', 'DESC')
       		->setParameter('id', $userId)
        ;

        return $qb->getQuery()->getResult();
	}

}
