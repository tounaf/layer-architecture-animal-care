<?php

namespace UI\Http\Admin\Form;

use Domain\User\Entity\Group;
use Domain\User\Entity\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class, [
                'required' => $options['is_new'],
                'constraints' => $options['is_new'] ? [new Length(['min' => 6])] : [],
                'help' => $options['is_new'] ? '' : 'Laissez vide pour ne pas modifier',
                'empty_data' => '',
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
            ])
            ->add('groups', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'groupName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('profiles', EntityType::class, [
                'class' => Profile::class,
                'choice_label' => 'profileName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'is_new' => true,
        ]);
    }
}
