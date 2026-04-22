<?php

namespace UI\Http\Admin\Form;

use Domain\Service\Repository\ServiceRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceProposeType extends AbstractType
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $services = $this->serviceRepository->findAll();
        $choices = [];
        foreach ($services as $service) {
            $choices[$service->getNom()] = (string) $service->getId();
        }

        $builder
            ->add('serviceId', ChoiceType::class, [
                'label' => 'Service',
                'choices' => $choices,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description spécifique',
                'required' => false
            ])
            ->add('actif', CheckboxType::class, [
                'label' => 'Actif',
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
