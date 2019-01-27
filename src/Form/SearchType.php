<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('media_type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'film' => 'movie',
                    'série TV' => 'tv_show'
                ],
                'attr' => [
                    'class' => 'form-control-lg search_options'
                ],
            ])
            ->add('search_type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'année' => 'year',
                    'genre' => 'genre'
                ],
                'attr' => [
                    'class' => 'form-control-lg search_options'
                ],
            ])
            ->add('search_type_field', TextType::class, [
                'label' => false,
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control-lg search_options_text_field',
                ]
            ])
            ->add('search', TextType::class, [
                'label' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control-lg search_field',
                    'placeholder' => 'Rechercher un film, une série TV...'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Recherche',
                'attr' => [
                    'class' => 'btn btn-danger btn-lg btn-submit ml-2',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
