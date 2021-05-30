<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Текст комментария не может быть пустым'
                    ]),
                    new Length([
                        'max' => 512,
                        'maxMessage' => 'Длина текста комментария не должна превышать {{ limit }} символов'
                    ])
                ]
            ])
            ->add('author', HiddenType::class)
            ->add('topic', HiddenType::class)
        ;

        $builder
            ->get('author')->addModelTransformer(new CallbackTransformer(
                function (User $user) {
                    return $user->getId();
                },
                function (int $userId) {
                    return $this->entityManager->getRepository(User::class)->find($userId);
                }
            ));
        $builder
            ->get('topic')->addModelTransformer(new CallbackTransformer(
                function (Topic $topic) {
                    return $topic->getId();
                },
                function (int $topicId) {
                    return $this->entityManager->getRepository(Topic::class)->find($topicId);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
