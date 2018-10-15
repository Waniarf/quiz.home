<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', EntityType::class, array(
                'class' => Question::class,
                'choice_label' => 'text',
                'mapped' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => 'true',
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'label' => false
        ]);
    }
}
