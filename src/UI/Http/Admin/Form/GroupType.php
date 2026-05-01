<?php

namespace UI\Http\Admin\Form;

use Domain\User\Entity\Profile;
use Domain\User\Entity\Right;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('groupName', TextType::class, ['label' => 'Nom du groupe'])
            ->add('rights', EntityType::class, [
                'class' => Right::class,
                'choice_label' => 'rightName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Droits'
            ])
            ->add('profiles', EntityType::class, [
                'class' => Profile::class,
                'choice_label' => 'profileName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Profils'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
