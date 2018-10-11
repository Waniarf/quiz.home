<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $quiz = new Quiz();
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'max-height' => '400px',
                ]
            ])
            ->add('IsActive', ChoiceType::class, array(
                'choices'  => array(
                    'Yes' => true,
                    'No' => false,
                ),
                'attr' => [

                ]
            ))
            ->add('question', EntityType::class, array(
                'class' => Question::class,
                'choice_label' => 'text',
                'mapped' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search'=>'true',
                ]
            ))

            ->add('save', SubmitType::class, array('label' => 'Save'))
//            ->add('createData')
//            ->add('isActive')
//            ->add('question')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
