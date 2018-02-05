<?php

namespace Tests\AppBundle\Validator\Constraints;

use AppBundle\Validator\Constraints\CardChecker;
use AppBundle\Validator\Constraints\CardCheckerValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\CardSchemeValidator;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

/**
 * Validator testing.
 *
 * @package Tests\AppBundle\Validator\Constraints
 * @author  Krzysztof Trzos
 */
class CardCheckerValidatorTest extends KernelTestCase
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
                CardCheckerValidator::class,
                CardSchemeValidator::class
            )
        );
    }

    /**
     * Testing main functionality of `CardCheckerValidator`.
     *
     * @param string $number
     * @param string $type
     * @param bool   $isValid
     * @return void
     * @dataProvider providerDataForValidation
     */
    public function testValidating(string $number, string $type, bool $isValid): void
    {
        # mock form
        $mockedForm = $this->getMockBuilder(\Symfony\Component\Form\Form::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData'])
            ->getMock();

        $mockedForm->expects($this->once())->method('getData')->willReturn([
            'card_number' => $number,
            'card_type'   => $type,
        ]);

        # mock validator context
        /* @var $mockedDownloader \PHPUnit_Framework_MockObject_MockObject */
        $mockedContext = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRoot', 'buildViolation'])
            ->getMock();

        $mockedContext
            ->expects($this->once())
            ->method('getRoot')
            ->willReturn($mockedForm);

        # mock validator violation
        $violation = $this->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();

        $mockedContext
            ->expects($isValid ? $this->never() : $this->once())
            ->method('buildViolation')
            ->willReturn($violation);

        # make validation
        /* @var $mockedContext ExecutionContext */

        $validator = new CardCheckerValidator();
        $validator->initialize($mockedContext);
        $validator->validate($number, new CardChecker(['schemes' => '']));
    }

    /**
     * Data provider for `testValidating()` method.
     *
     * @return \Generator
     */
    public function providerDataForValidation(): \Generator
    {
        yield ['378282246310005', 'AMEX', true];
        yield ['5555555555554444', 'MASTERCARD', true];
        yield ['4012888888881881', 'VISA', true];
        yield ['378282246310005', 'MASTERCARD', false];
        yield ['12345', 'MASTERCARD', false];
        yield ['12345', 'AMEX', false];
        yield ['5555555555554444', 'AMEX', false];
        yield ['5555555555554444', 'VISA', false];
    }

    /**
     * Test whether parallel form field with card type is defined.
     *
     * @return void
     */
    public function testNoCardTypeError(): void
    {
        # mock form
        $mockedForm = $this->getMockBuilder(\Symfony\Component\Form\Form::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData'])
            ->getMock();

        $mockedForm->expects($this->once())->method('getData')->willReturn([]);

        # mock validator context
        /* @var $mockedDownloader \PHPUnit_Framework_MockObject_MockObject */
        $mockedContext = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRoot'])
            ->getMock();

        $mockedContext
            ->expects($this->once())
            ->method('getRoot')
            ->willReturn($mockedForm);

        # make validation and expect Exception
        $this->expectException(MissingOptionsException::class);

        /* @var $mockedContext ExecutionContext */

        $validator = new CardCheckerValidator();
        $validator->initialize($mockedContext);
        $validator->validate('123', new CardChecker(['schemes' => '']));
    }
}