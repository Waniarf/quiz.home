<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\QuestionOption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CreateQuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Text', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('questionOptions', CollectionType::class, array(
                'entry_type' => QuestionOptionType::class,
            ))
            ->add('save', SubmitType::class, array('label' => 'Save'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
