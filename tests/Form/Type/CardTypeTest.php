<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Type\CardType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests for `CardType` form type.
 *
 * @package Tests\AppBundle\Form\Type
 * @author  Krzysztof Trzos
 */
class CardTypeTest extends KernelTestCase
{
    /**
     * @return void
     */
    public function testBasics(): void
    {
        self::assertTrue(class_exists(CardType::class));
    }
}