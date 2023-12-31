<?php

namespace AppBundle\Form;

use AppBundle\Entity\BatimentNouveau;
use AppBundle\Entity\Batiment;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class BatimentNouveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('pans', TextType::class, [
                'label' => 'Pans',
                'required' => false,
            ])
            ->add('longueur', TextType::class, [
                'label' => 'Longueur (m)',
                'required' => false,
            ])
            ->add('largeur', TextType::class, [
                'label' => 'Largeur (m)',
                'required' => false,
            ])
            ->add('faitage', TextType::class, [
                'label' => 'Faitage (m)',
                'required' => false,
            ])
            ->add('surfaceSol', TextType::class, [
                'label' => 'Surface au sol (m2)',
                'required' => false,
            ])
            ->add('charge', ChoiceType::class, [
                'label' => 'Charge',
                'required' => false,
                'choices' => array_flip(Batiment::getChargeList()),
            ])
            ->add('bardage', TextType::class, [
                'label' => 'Bardage',
                'required' => false,
            ])
            ->add('ossature', TextType::class, [
                'label' => 'Ossature',
                'required' => false,
            ])
            ->add('charpente', TextType::class, [
                'label' => 'Charpente',
                'required' => false,
            ])
            ->add('couverture', TextType::class, [
                'label' => 'Couverture',
                'required' => false,
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('photo2File', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('photo3File', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('photo4File', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('toitures', CollectionType::class, [
                'entry_type' => ToitureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => null,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\BatimentNouveau',
        ]);
    }
}
