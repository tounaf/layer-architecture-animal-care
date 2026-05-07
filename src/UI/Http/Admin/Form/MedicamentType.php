<?php

namespace UI\Http\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du médicament'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('prixUnitaire', NumberType::class, ['label' => 'Prix unitaire (EUR)'])
            ->add('stockActuel', IntegerType::class, ['label' => 'Stock initial', 'disabled' => $options['is_edit']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'is_edit' => false,
        ]);
    }
}
