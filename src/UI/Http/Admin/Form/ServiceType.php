<?php

namespace UI\Http\Admin\Form;

use Domain\Service\Entity\ServiceCategorie;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function __construct(
        private ServiceCategorieRepositoryInterface $categorieRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = $this->categorieRepository->findAll();
        $choices = [];
        foreach ($categories as $categorie) {
            $choices[$categorie->getNom()] = (string) $categorie->getId();
        }

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('code', TextType::class, [
                'label' => 'Code unique'
            ])
            ->add('categorieId', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => $choices,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('dureeDefaultMinutes', IntegerType::class, [
                'label' => 'Durée par défaut (minutes)'
            ])
            ->add('necessiteAcompteDefault', CheckboxType::class, [
                'label' => 'Nécessite un acompte par défaut',
                'required' => false
            ])
            ->add('montantTarif', NumberType::class, [
                'label' => 'Tarif (EUR)',
                'mapped' => false,
                'required' => false
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
