<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RoverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roverPosition', TextType::class, [
                'label'       => 'Rover position',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Ex: 1 2 N'
                ],
            ])
            ->add('instructions', TextType::class, [
                'label'       => 'Instructions',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Ex: LMLMLMLMM'
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
        return 'rover_form';
    }
}
