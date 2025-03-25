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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'titre',
                TextType::class,
                [
                    'label' => 'Titre du livre',
                    'attr' => ['maxlength' => 255]
                ]
            )
            ->add('nbPages')
            ->add('nbExemplaires', IntegerType::class, [
                'label' => 'Quantité en stock',
                'attr' => ['min' => 0]
            ])
            ->add('dateEdition', DateType::class, [
                'label' => 'Date d\'édition',
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix unitaire (€)',
                'scale' => 2,
                'html5' => true,
                'attr' => ['step' => 0.01]
            ])
            ->add('isbn', TextType::class, [
                'label' => 'Code ISBN',
                'attr' => ['pattern' => '[0-9]{13}'],
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nomEditeur',
                'label' => 'Éditeur',
                'placeholder' => 'Choisir un éditeur'
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'designation',
                'label' => 'Catégorie',
                'multiple' => false,
                'placeholder' => 'Choisir une catégorie'
            ])
            ->add(
                'auteurs',
                EntityType::class,
                [
                    'class' => Auteur::class,
                    'choice_label' => function (Auteur $auteur) {
                        return $auteur->getPrenom() . ' ' . $auteur->getNom();
                    },
                    'label' => 'Choisir Auteur(s) du Livre',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
