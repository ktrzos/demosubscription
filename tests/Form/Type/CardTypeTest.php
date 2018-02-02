<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Type\CardType;
use AppBundle\Validator\Constraints\CardChecker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints;

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
        self::bootKernel();

        $formBuilder = self::$kernel->getContainer()
            ->get('form.factory')
            ->createNamedBuilder('test', CardType::class);

        self::assertCount(4, $formBuilder->all());
        self::assertNotNull($formBuilder->get('card_number'));
        self::assertNotNull($formBuilder->get('cvv_number'));
        self::assertNotNull($formBuilder->get('card_type'));
        self::assertNotNull($formBuilder->get('submit'));

        $cardNoConstraints = $formBuilder->get('card_number')->getFormConfig()->getOption('constraints');
        $cvvConstraints    = $formBuilder->get('cvv_number')->getFormConfig()->getOption('constraints');
        $typeConstraints   = $formBuilder->get('card_type')->getFormConfig()->getOption('constraints');

        self::assertCount(3, $cardNoConstraints);
        self::assertCount(1, $cvvConstraints);
        self::assertCount(1, $typeConstraints);

        self::assertInstanceOf(Constraints\NotBlank::class, $cardNoConstraints[0]);
        self::assertInstanceOf(Constraints\Luhn::class, $cardNoConstraints[1]);
        self::assertInstanceOf(CardChecker::class, $cardNoConstraints[2]);

        self::assertInstanceOf(Constraints\NotBlank::class, $cvvConstraints[0]);

        self::assertInstanceOf(Constraints\NotBlank::class, $typeConstraints[0]);
    }
}