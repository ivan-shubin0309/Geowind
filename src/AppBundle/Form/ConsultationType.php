<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DatePickerType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('from', EmailType::class, [
                'label' => 'Expéditeur',
                'disabled' => true,
            ])
            ->add('to', EmailType::class, [
                'label' => 'Destinataire',
                'required' => true,
            ])
            /* ->add('replyTo', EmailType::class, [
                'label' => 'Répondre à',
                'required' => true,
            ]) */
            ->add('object', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'rows' => 15,
                ]
            ])
            ->add('documentFile', FileType::class, [
                'label' => 'Fichier',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Consultation',
        ]);
    }
}
