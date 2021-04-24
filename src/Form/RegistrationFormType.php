<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'Некорректный email'
                    ]),
                    new Length([
                        'max' => 255
                    ])
                ],
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => 'Введите email'
                ]
            ])
            ->add('name', null, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Имя должно быть не менее {{ limit }} символов',
                        'max' => 255
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Введите имя'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен быть не менее {{ limit }} символов',
                        'max' => 255
                    ]),
                    new Regex([
                        'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/',
                        'message' => 'Пароль должен состоять из латинских заглавных и строчных букв, содержать цифры и символы !@#$%^&*'
                    ])
                ],
                'first_options'  => [
                    'attr' => [
                        'maxlength' => 255,
                        'placeholder' => 'Введите пароль'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'maxlength' => 255,
                        'placeholder' => 'Повторите пароль'
                    ]
                ],
                'invalid_message' => 'Пароли не совпадают'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Вы должны согласиться на обработку персональных данных'
                    ]),
                ],
                'label' => 'Согласие на обработку персональных данных'
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
