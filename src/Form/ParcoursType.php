<?php

namespace App\Form;

use App\Entity\Difficulte;
use App\Entity\Parcours;
use App\Entity\TypeDeParcours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomParcours')
            ->add('prive')
            ->add('creePar')
            ->add('exclusif')
            ->add('typeDeParcours', EntityType::class, [
                'class' => TypeDeParcours::class,
                'choice_label' => 'libelleParcours',
            ])
            ->add('difficulte', EntityType::class, [
                'class' => Difficulte::class,
                'choice_label' => 'libelleDifficulte',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcours::class,
        ]);
    }
}
