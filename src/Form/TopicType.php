<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TopicType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Название топика не может быть пустым'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Длина названия топика не должна превышать {{ limit }} символов'
                    ])
                ]
            ])
            ->add('text', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Текст топика не может быть пустым'
                    ]),
                    new Length([
                        'max' => 5000,
                        'maxMessage' => 'Длина текста топика не должна превышать {{ limit }} символов'
                    ])
                ]
            ])
            ->add('author', HiddenType::class)
        ;

        $builder->get('author')
            ->addModelTransformer(new CallbackTransformer(
                function (User $user) {
                    return $user->getId();
                },
                function (int $userId) {
                    return $this->entityManager->getRepository(User::class)->find($userId);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
