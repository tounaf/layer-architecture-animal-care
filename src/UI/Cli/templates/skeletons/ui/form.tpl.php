<?php

namespace UI\Http\{{ context }}\Form;

use Domain\{{ name }}\Entity\{{ name }};
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class {{ name }}Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'Identifiant',
                'attr' => ['placeholder' => 'Ex: 12345']
            ])
            // Ajoutez vos champs ici
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => {{ name }}::class,
        ]);
    }
}
