<?php

namespace UI\Http\Admin\Form;

use Domain\User\Entity\Right;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profileName', TextType::class, ['label' => 'Nom du profil'])
            ->add('rights', EntityType::class, [
                'class' => Right::class,
                'choice_label' => 'rightName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Droits'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
