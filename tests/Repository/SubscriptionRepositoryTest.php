<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests for `SubscriptionRepository` Doctrine ORM repository.
 *
 * @package Tests\AppBundle\Repository
 * @author  Krzysztof Trzos
 */
class SubscriptionRepositoryTest extends KernelTestCase
{
    /**
     * @var SubscriptionRepository
     */
    private $repo;

    /** @inheritdoc */
    protected function setUp()
    {
        parent::setUp();

        $this->loadRepo();
    }

    /**
     * Load repository.
     *
     * @return void
     */
    private function loadRepo(): void
    {
        if($this->repo === null) {
            self::bootKernel();
            $this->repo = self::$kernel->getContainer()
                ->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Subscription');
        }
    }

    /**
     * Basic assertions.
     *
     * @return void
     */
    public function testBasics(): void
    {
        self::assertTrue(
            is_subclass_of(
                SubscriptionRepository::class,
                EntityRepository::class
            )
        );

        self::assertTrue(method_exists($this->repo, 'findOutdated'));
        self::assertTrue(method_exists($this->repo, 'findByUser'));
        self::assertTrue(method_exists($this->repo, 'findByIds'));
    }

    /**
     * Test finding multiple entities by their IDs.
     *
     * @return void
     */
    public function testFindByIds(): void
    {
        $result = $this->repo->findByIds([1, 3]);

        self::assertSame([
            $this->repo->find(1),
            $this->repo->find(3),
        ], $result);
    }

    /**
     * Test finding multiple entities by their IDs.
     *
     * @return void
     */
    public function testFindByIds2(): void
    {
        $result = $this->repo->findByIds([3, 1]);

        self::assertSame([
            $this->repo->find(1),
            $this->repo->find(3),
        ], $result);
    }

    /**
     * Test finding multiple entities by User which is related with them.
     *
     * @param int   $userId
     * @param array $result
     * @return void
     * @dataProvider dataFindingByUser
     */
    public function testFindingByUser(int $userId, array $result): void
    {
        $list1 = [];
        $list2 = [];

        foreach($result as $item) {
            $list1[] = $item->getId();
        }

        foreach($this->repo->findByUser($userId) as $item) {
            $list2[] = $item->getId();
        }

        self::assertSame($list1, $list2);
    }

    /**
     * Data provider for `testFindingByUser()` testing method.
     *
     * @return \Generator
     */
    public function dataFindingByUser(): \Generator
    {
        $this->loadRepo();

        yield [1, [$this->repo->find(1)]];
        yield [3, [$this->repo->find(3)]];
        yield [55, []];
    }

    /**
     * Test finding outdated subscriptions with `findOutdated()` method.
     *
     * @return void
     * @after testFindByIds
     */
    public function testFindingOutdatedSubscriptions(): void
    {
        $list = [];

        foreach($this->repo->findOutdated() as $item) {
            $list[] = $item->getId();
        }

        self::assertSame([2, 3], $list);
    }
}