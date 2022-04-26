<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plateauCoordinates', TextType::class, [
                'label'       => 'Plateau upper-right coordinates',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Ex: 5 5'
                ],
            ])
            ->add('roverPositions', CollectionType::class, [
                'label'        => 'Rover Positions',
                'entry_type'   => RoverType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'required'     => true
                ]
            )
            ->add('calculate', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'challenge_form';
    }
}
