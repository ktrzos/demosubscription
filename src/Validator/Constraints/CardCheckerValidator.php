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

    /** @inheritdoc */
    public function validate($value, Validator\Constraint $constraint): void
    {
        /* @var $constraint CardChecker */
        /* @var $obj \Symfony\Component\Form\Form */
        $obj                 = $this->context->getRoot();
        $constraint->schemes = $obj->getData()['card_type'] ?? null;

        if($constraint->schemes === null) {
            throw new Validator\Exception\MissingOptionsException(
                'Parallel form field with card type must be defined.',
                ['schemes']
            );
        }

        parent::validate($value, $constraint);
    }
}