<?php

namespace Tests\AppBundle\Validator\Constraints;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Constaint tests.
 *
 * @package Tests\AppBundle\Validator\Constraints
 * @author  Krzysztof Trzos
 */
class CardCheckerTest extends KernelTestCase
{
    /**
     * Test basics.
     *
     * @return void
     */
    public function testBasics(): void
    {
        self::assertTrue(
            is_subclass_of(
                \AppBundle\Validator\Constraints\CardChecker::class,
                \Symfony\Component\Validator\Constraints\CardScheme::class
            )
        );
    }
}