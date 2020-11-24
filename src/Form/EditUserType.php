<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email' , EmailType::class, [
                'constraints' => [
                    new NotBlank([ 
                    'message' => 'Merci de saisir une adresse email'
                    ])
            ],
            'required' => true,
            'attr'=> [
                'class'=> 'form-control'
            ]
            ])
            
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    'utilisateur'=>'ROLE_USER',
                    'PRO'=>'ROLE_PRO',
                    'ADMIN'=>'ROLE_ADMIN'
                ],
                'expanded'=> true,
                'multiple'=> true,
                'label'=> 'Rôles'
            ])
            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
