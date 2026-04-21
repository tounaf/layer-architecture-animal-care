<?php

namespace UI\Http\Admin\Form;

use Application\Service\Command\CreerServiceCategorieCommand;
use Application\Service\Command\ModifierServiceCategorieCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('icone', TextType::class, [
                'label' => 'Icône (ex: ti ti-package)',
                'required' => false
            ])
            ->add('ordreAffichage', IntegerType::class, [
                'label' => "Ordre d'affichage"
            ]);

        if ($options['is_update']) {
            $builder->add('actif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'is_update' => false
        ]);
    }
}
