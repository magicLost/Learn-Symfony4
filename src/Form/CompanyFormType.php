<?php

namespace App\Form;

use App\Entity\Admin\Company;
use App\Entity\Admin\User;
use App\Entity\Admin\UserCompany;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('foundedAt', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('usersWorkingIn', EntityType::class, [
                'class' => UserCompany::class,
                'query_builder' => function($repository){
                    $repository->findUsersToForm();
                },
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'user',
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

}
