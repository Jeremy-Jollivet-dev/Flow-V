<?php

namespace App\Form;

use App\Entity\PointsMAP;
use App\Entity\TypeDePoints;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointsMAPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lat', NumberType::class, [
                'label' => 'Latitude',
                'attr' => ['step' => '0.000001'], // Définir une précision pour la latitude
            ])
            ->add('lon', NumberType::class, [
                'label' => 'Longitude',
                'attr' => ['step' => '0.000001'], // Définir une précision pour la longitude
            ])
            ->add('details', TextType::class, [
                'label' => 'Détails du point',
                'required' => false,
            ])
            ->add('typeDePoints', EntityType::class, [
                'class' => TypeDePoints::class,
                'choice_label' => 'libelleTypePoint',
                'choice_value' => function (?TypeDePoints $typeDePoints) {
                    return $typeDePoints ? $typeDePoints->getId() : ''; // Retourne l'ID de l'entité
                },
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PointsMAP::class,
        ]);
    }
}
