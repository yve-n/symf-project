<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => false ,
                'attr'=> [
                    'class' => 'form-control-user',
                    'placeholder' => 'lastname'
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => false ,
                'attr'=> [
                    'class' => 'form-control-user',
                    'placeholder' => 'firstname'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false ,
                'attr'=> [
                    'class' => 'form-control-user',
                    'placeholder' => 'email'
                ],
            ])
            ->add('address' , TextType::class, [
                'label' => false ,
                'attr' => [
                    'class' => 'form-control-user',
                    'placeholder' => 'address'
                ]
            ])
            ->add('zipCode' , TextType::class, [
                'label' => false ,
                'attr' => [
                    'class' => 'form-control-user',
                    'placeholder' => 'zipcode'
                ]
            ])
            ->add('city' , TextType::class, [
                'label' => false ,
                'attr' => [
                    'class' => 'form-control-user',
                    'placeholder' => 'city'
                ]
            ])
            ->add('country' , CountryType::class, [
                'label' => false ,
                'placeholder' => 'country',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('rgpdConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our RGPD terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => false ,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control-user',
                    'placeholder' => 'password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class,[
                'label' => 'Rôles',
                'choices' =>[
                    'admin' => 'ROLE_ADMIN',
                    'user'  => 'ROLE_USER'
                ],
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
