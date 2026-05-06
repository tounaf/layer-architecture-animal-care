<?php

namespace UI\Http\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomStructure', TextType::class, ['label' => 'Nom de la structure'])
            ->add('nomContact', TextType::class, ['label' => 'Nom du contact'])
            ->add('prenomContact', TextType::class, ['label' => 'Prénom du contact'])
            ->add('profession', TextType::class, ['label' => 'Profession'])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('valideParAdmin', CheckboxType::class, [
                'label' => 'Validé par l\'administration',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
