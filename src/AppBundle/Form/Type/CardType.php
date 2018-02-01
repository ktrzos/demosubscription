<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\Luhn;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @package AppBundle\Form\Type
 * @author  Krzysztof Trzos
 */
class CardType extends Form\AbstractType
{
    /** @inheritdoc */
    public function buildForm(Form\FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('card_number', Type\TextType::class, [
            'required'    => true,
            'constraints' => [
                new NotBlank(),
                new Luhn(),
                new \AppBundle\Validator\Constraints\CardChecker([
                    'schemes' => 'AMEX'
                ]),
            ],
        ]);

        $builder->add('cvv_number', Type\TextType::class, [
            'required'    => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        $builder->add('card_type', Type\ChoiceType::class, [
            'required'    => true,
            'constraints' => [
                new NotBlank(),
            ],
            'choices'     => [
                'MasterCard'      => 'MASTERCARD',
                'Visa'            => 'VISA',
                'AmericanExpress' => 'AMEX',
            ],
        ]);

        $builder->add('submit', Type\SubmitType::class);
    }
}