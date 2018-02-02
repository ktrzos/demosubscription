<?php

namespace AppBundle\Entity;

/**
 * Entity type representing single subscription payment.
 *
 * @package AppBundle\Entity
 * @author  Krzysztof Trzos
 */
class SubscriptionPayment
{
    /** @var int|null */
    private $id;

    /** @var Subscription */
    private $subscription;

    /** @var int */
    private $chargedAmount = 0;

    /** @var \DateTime */
    private $date;

    /** @var \DateTime|null */
    private $updatedAt;

    /** @var \DateTime|null */
    private $createdAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription(Subscription $subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * @return int
     */
    public function getChargedAmount(): int
    {
        return $this->chargedAmount;
    }

    /**
     * @param int $chargedAmount
     */
    public function setChargedAmount(int $chargedAmount): void
    {
        $this->chargedAmount = $chargedAmount;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
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
}