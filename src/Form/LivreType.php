<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('nbPages')
            ->add('nbExemplaires')
            ->add('dateEdition', null, [
                'widget' => 'single_text',
            ])
            ->add('prix')
            ->add('isbn')
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nomEditeur',
                'placeholder' => 'Choisir un éditeur'
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'designation',
                'placeholder' => 'Choisir une catégorie'
            ])
            ->add('auteurs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
