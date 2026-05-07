<?php

namespace UI\Http\Admin\Form;

use Infrastructure\Shared\Service\RouteExtractor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RightType extends AbstractType
{
    public function __construct(
        private RouteExtractor $routeExtractor
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $routes = $this->routeExtractor->getAllRoutes();
        $choices = [];
        foreach ($routes as $name => $info) {
            $choices[$info['path'] . " (" . $name . ")"] = $name;
        }
        ksort($choices);

        $builder
            ->add('rightName', TextType::class, ['label' => 'Nom du droit'])
            ->add('rightCode', ChoiceType::class, [
                'label' => 'Route associée (Code)',
                'choices' => $choices,
                'placeholder' => '-- Choisir une route --',
                'attr' => ['class' => 'select2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
