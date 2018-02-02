<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator;
use Symfony\Component\Validator\Constraints\CardSchemeValidator;

/**
 * @package AppBundle\Validator\Constraints
 * @author  Krzysztof Trzos
 */
class CardCheckerValidator extends CardSchemeValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed                $value      The value that should be validated
     * @param Validator\Constraint $constraint The constraint for the validation
     */
    public function validate($value, Validator\Constraint $constraint)
    {
        /* @var $constraint CardChecker */
        /* @var $obj \Symfony\Component\Form\Form */
        $obj                 = $this->context->getRoot();
        $cardType            = $obj->getData()['card_type'];
        $constraint->schemes = $cardType;

        parent::validate($value, $constraint);
    }
}