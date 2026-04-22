<?php

namespace UI\Http\Admin\Form;

use Domain\Client\Repository\ClientRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $clients = $this->clientRepository->findAll();
        $choices = [];
        foreach ($clients as $client) {
            $choices[$client->getNom() . ' ' . $client->getPrenom()] = (string) $client->getId();
        }

        $builder
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('espece', TextType::class, [
                'label' => 'Espèce',
                'required' => false
            ])
            ->add('race', TextType::class, [
                'label' => 'Race',
                'required' => false
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false
            ])
            ->add('poids', NumberType::class, [
                'label' => 'Poids (kg)',
                'required' => false
            ])
            ->add('proprietaireId', ChoiceType::class, [
                'label' => 'Propriétaire',
                'choices' => $choices,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
