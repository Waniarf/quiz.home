<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'quiz.name',
                'attr' => [
                    'class' => 'form-control',
                ]

            ])
            ->add('description', TextareaType::class, array(
                'label' => 'quiz.description',
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn',
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
