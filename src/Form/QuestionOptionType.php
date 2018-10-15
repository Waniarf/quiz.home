<?php

namespace App\Form;

use App\Entity\QuestionOption;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('IsValid', RadioType::class, array(
            ))
            ->add('Text', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'input variable answer here',
                    'width' => '85%',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestionOption::class,
            'label' => false
        ]);
    }
}
