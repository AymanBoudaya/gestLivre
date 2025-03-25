<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Editeur;
use App\Entity\Categorie;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('titre', TextType::class, [
        'required' => false,
        'label' => 'Titre du livre',
        'attr' => [
          'placeholder' => 'Rechercher par titre...',
          'class' => 'form-control',
        ]
      ])
      ->add('editeur', EntityType::class, [
        'required' => false,
        'label' => 'Filtrer par éditeur',
        'class' => Editeur::class,
        'choice_label' => 'nomEditeur',
        'placeholder' => 'Tous les éditeurs'
      ])
      ->add('categorie', EntityType::class, [
        'required' => false,
        'label' => 'Filtrer par catégorie',
        'class' => Categorie::class,
        'choice_label' => 'designation',
        'placeholder' => 'Toutes les catégories'
      ])
      ->add('rechercher', SubmitType::class, [
        'label' => 'Rechercher',
        'attr' => ['class' => 'btn btn-primary']
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      // Configurez votre formulaire pour ne pas lier à une entité
      'csrf_protection' => false,
      'method' => 'GET'
    ]);
  }
}