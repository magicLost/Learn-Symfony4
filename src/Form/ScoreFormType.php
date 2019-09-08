<?php

namespace App\Form;


use App\Entity\Score\Score;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScoreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'pattern' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'maxlength' => 15,
                    'minlength' => 2
                ]
            ])
            ->add('real_name', TextType::class, [
                'label' => 'Real name',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter real name',
                    'pattern' => '[a-zA-Z][a-zA-Z0-9 -]*',
                    'maxlength' => 15,
                    'minlength' => 2
                ]
            ])
            ->add('score', IntegerType::class, [
                'label' => 'Score',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter user result',
                    'min' => 0
                ]
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => 'Is user active?',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Score::class
        ]);
    }

}