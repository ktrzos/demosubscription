<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Subscription entity type.
 *
 * @package AppBundle\Entity
 * @author  Krzysztof Trzos
 */
class Subscription
{
    public const STATUS_NEW = 'new';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELLED = 'cancelled';

    /** @var int|null */
    private $id;

    /** @var int */
    private $userId;

    /** @var int */
    private $shippingAddress;

    /** @var int */
    private $billingAddress;

    /** @var string */
    private $status = self::STATUS_NEW;

    /** @var int */
    private $pack;

    /** @var \DateTime|null */
    private $startedAt;

    /** @var \DateTime|null */
    private $updatedAt;

    /** @var \DateTime */
    private $createdAt;

    /** @var Collection|SubscriptionPayment[] */
    private $payments;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->payments  = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getShippingAddress(): int
    {
        return $this->shippingAddress;
    }

    /**
     * @param int $shippingAddress
     */
    public function setShippingAddress(int $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return int
     */
    public function getBillingAddress(): int
    {
        return $this->billingAddress;
    }

    /**
     * @param int $billingAddress
     */
    public function setBillingAddress(int $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @param string $status
     * @throws \InvalidArgumentException
     */
    public function setStatus(string $status): void
    {
        if(
            false === \in_array($status, [
                self::STATUS_NEW,
                self::STATUS_ACTIVE,
                self::STATUS_CANCELLED,
            ], true)
        ) {
            throw new \InvalidArgumentException('Invalid status value!');
        }

        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getPack(): int
    {
        return $this->pack;
    }

    /**
     * @param int $pack
     */
    public function setPack(int $pack): void
    {
        $this->pack = $pack;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime|null $startedAt
     */
    public function setStartedAt(?\DateTime $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return SubscriptionPayment[]|Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }
}