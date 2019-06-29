<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('username', TextType::class, [
		        'label' => 'Pseudo'
	        ])
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
	            'type' => PasswordType::class,
	            'required' => true,
	            'first_options' => ['label' => 'Mot de passe'],
	            'second_options' => ['label' => 'Confirmer votre mot de passe'],
                'mapped' => false,
                'invalid_message' => 'Vous devez saisir le même mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit au moins faire {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
	        ->add('address')
	        ->add('cp')
	        ->add('ville')
	        ->add('pays', CountryType::class)
	        ->add('dateNaissance', DateType::class, [
	        	'widget' => 'single_text'
	        ])
	        ->add('termsAccepted', CheckboxType::class, [
	        	'mapped' => 'false',
		        'constraints' => new IsTrue(),
	            'label' => "J'accepte les conditions d'utilisations"
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
