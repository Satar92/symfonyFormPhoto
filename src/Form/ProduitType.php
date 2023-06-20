<?php


namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints;





class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Référence',
                'constraints' => [
                    new NotBlank(['message' => 'La référence ne peut pas être vide.']),
                ],
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(['message' => 'Le titre ne peut pas être vide.']),
                    new Length(['max' => 255, 'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'La description ne peut pas être vide.']),
                ],
            ])
            ->add('couleur', TextType::class, [
                'label' => 'Couleur',
                'constraints' => [
                    new NotBlank(['message' => 'La couleur ne peut pas être vide.']),
                ],
            ])
            ->add('taille', TextType::class, [
                'constraints' => [
                    new Constraints\Type([
                        'type' => 'string',
                        'message' => 'La taille doit être une chaîne de caractères.',
                    ]),
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Homme' => 'm',
                    'Femme' => 'f',
                ],
                'constraints' => [
                    new Choice(['choices' => ['m', 'f'], 'message' => 'Veuillez sélectionner une option valide.']),
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'constraints' => [
                    new NotBlank(['message' => 'La photo ne peut pas être vide.']),
                ],
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank(['message' => 'Le prix ne peut pas être vide.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le prix doit être supérieur à 0.']),
                ],
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
                'constraints' => [
                    new NotBlank(['message' => 'Le stock ne peut pas être vide.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le stock doit être supérieur à 0.']),
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Sélectionner une catégorie',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner une catégorie.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            // configure the form options if needed
        ]);
    }
}
