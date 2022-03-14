<?php

namespace App\Form;

// use App\Classe\Search;
// use App\Entity\Produits;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\OptionsResolver\OptionsResolver;

// class SearchType extends AbstractType
// {

//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
// //Formulaire traité via l’input
//             ->add('string', TextType::class, [
//                 'label' => false,
//                 'required'=> false,
//                 'attr' => [
//                     'placeholder' => 'Votre recherche...',
//                     'class' => 'form-control-sm'
//                 ]
//             ])
// // Formulaire traité via checkbox
// //             On donne au bouton le nom de ce que l'on recherche ( dans Search.php)
//             // ->add('categories', EntityType::class, [ //Cette catégorie de traitement représente une entité
//             //     'label' => false,
//             //     'required' => false,
//             //     'class' => Produits::class, //On précise avec quel class on fait le lien.
//             //     'multiple' => true, // possibilité de selectionner plusieurs valeurs
//             //     'expanded' => true, // vue en checkbox
//             // ])
//             // // Ajout du bouton qui traite la recherche du formulaire
//             ->add('submit', SubmitType::class, [
//                 'label' => 'Filtrer',
//                 'attr' => [
//                     'class' => 'btn-block btn-info'
//                 ]
//             ])
//         ;
//     }

//     //function d'options du formulaire symfony
//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             'data_class' => Search::class, // on lie les data du formulaire à la class Search.php
//             'method' => 'GET', // par l'url
//             'crsf_protection' => false, //descativation du cryptage
//         ]);
//     }

//     public function getBlockPrefix()
//     {
//         return'';
//         //on empeche de retourner un tableau avec des valeurs préfixé du nom de la class search et l'affichage dans l'url
//     }
// }
