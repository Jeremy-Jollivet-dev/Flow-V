<?php

namespace App\Form;

use App\Entity\Difficulte;
use App\Entity\Parcours;
use App\Entity\TypeDeParcours;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\PointsMAPType;
use Symfony\Component\Form\FormBuilderInterface;

class Parcours1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomParcours')
            ->add('prive')
            ->add('exclusif')
            ->add('typeDeParcours', EntityType::class, [
                'class' => TypeDeParcours::class,
                'choice_label' => 'libelleParcours',
                'attr' => ['class' => 'combo-box'],
            ])
            ->add('difficulte', EntityType::class, [
                'class' => Difficulte::class,
                'choice_label' => 'libelleDifficulte',
                'attr' => ['class' => 'combo-box'],
            ])
            // Champ pour les points de parcours
            /*->add('pointsMAPs', CollectionType::class, [
                'entry_type' => PointsMAPType::class, // Formulaire pour chaque point
                'entry_options' => ['label' => false],
                'allow_add' => true, // Permet d'ajouter des points dynamiquement
                'allow_delete' => true, // Permet de supprimer des points
                'by_reference' => false,
            ])*/
            // Champs cachés pour les points (si nécessaire, comme pour un format JSON)
            ->add('start_point', HiddenType::class, [
                'mapped' => false, // Le champ ne sera pas lié à l'entité
            ])
            ->add('end_point', HiddenType::class, [
                'mapped' => false, // Le champ ne sera pas lié à l'entité
            ])
            ->add('intermediate_points', HiddenType::class, [
                'mapped' => false, // Le champ ne sera pas lié à l'entité
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcours::class,
        ]);
    }
}
