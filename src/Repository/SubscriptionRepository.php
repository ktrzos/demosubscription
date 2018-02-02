<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Subscription;
use AppBundle\Entity\SubscriptionPayment;
use Doctrine\ORM;

/**
 * Repository of `Subscription` entity type.
 *
 * @package AppBundle\Repository
 * @author  Krzysztof Trzos
 */
class SubscriptionRepository extends ORM\EntityRepository
{
    /**
     * Find all outdated subscriptions (with last payment done more than 7 days
     * after the subscription end date).
     *
     * @return Subscription[]
     */
    public function findOutdated(): array
    {
        # get outdated subscriptions IDs with use of native query
        $rsm = new ORM\Query\ResultSetMapping();
        $rsm->addScalarResult('id', 'id');

        $sql = '
            SELECT s.id
            FROM subscriptions s
            JOIN subscriptions_payments p ON p.id = (
              SELECT p2.id 
              FROM subscriptions_payments p2 
              WHERE p2.subscription_id = s.id 
              ORDER BY p2.date DESC 
              LIMIT 1
            )
            WHERE 
              s.status = :status
        ';

        $dbDriver = $this->_em->getConnection()->getDriver()->getName();

        if($dbDriver === 'pdo_sqlite') {
            $sql .= "AND DATETIME('now','localtime') > DATETIME(p.date,'+'||'37 days')";
        } else {
            $sql .= 'AND NOW() > DATE_ADD(p.date, INTERVAL 37 DAY)';
        }

        $query = $this->_em->createNativeQuery($this->securityFallback($sql), $rsm);
        $query->setParameter('status', Subscription::STATUS_ACTIVE);

        # simplify list of IDs
        $ids = array_map(function ($item) {
            return $item['id'];
        }, $query->getResult());

        # return proper result
        return $this->findByIds($ids);
    }

    /**
     * Find all subscriptions for particular User ID.
     *
     * @param int $id
     * @return Subscription[]
     */
    public function findByUser(int $id): array
    {
        # get outdated subscriptions IDs with use of native query
        $rsm = new ORM\Query\ResultSetMapping();
        $rsm->addScalarResult('id', 'id');

        $sql = '
            SELECT s.id
            FROM subscriptions s
            LEFT JOIN subscriptions_payments p ON p.id = (
              SELECT p2.id 
              FROM subscriptions_payments p2 
              WHERE p2.subscription_id = s.id 
              ORDER BY p2.date DESC 
              LIMIT 1
            )
            WHERE s.user_id = :user_id
        ';

        $query = $this->_em->createNativeQuery($this->securityFallback($sql), $rsm);
        $query->setParameter('user_id', $id);

        # simplify list of IDs
        $ids = array_map(function ($item) {
            return $item['id'];
        }, $query->getResult());

        # return proper result
        return $this->findByIds($ids);
    }

    /**
     * Fallback when names of tables will change in future.
     *
     * @param string $sql
     * @return string
     */
    private function securityFallback(string $sql): string
    {
        $subsTableName = $this->_em
            ->getClassMetadata(Subscription::class)
            ->getTableName();

        $subsPaymentTableName = $this->_em
            ->getClassMetadata(SubscriptionPayment::class)
            ->getTableName();

        return str_replace(
            ['subscriptions', 'subscriptions_payments'],
            [$subsTableName, $subsPaymentTableName],
            $sql
        );
    }

    /**
     * Find subscriptions by many IDs.
     *
     * @param array $ids
     * @return Subscription[]
     */
    public function findByIds(array $ids): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s');
        $qb->andWhere('s.id IN (:ids)');
        $qb->setParameter('ids', $ids);

        # return proper result
        return $qb->getQuery()->execute();
    }
}