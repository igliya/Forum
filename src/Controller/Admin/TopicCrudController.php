<?php

namespace App\Controller\Admin;

use App\Entity\Topic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TopicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Topic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Топики')
            ->setEntityLabelInSingular('Топик')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title')->setLabel('Заголовок');
        yield TextEditorField::new('text')->setLabel('Текст')->hideOnIndex();
        yield DateTimeField::new('createdDate')
            ->setLabel('Дата создания')
            ->setFormat('dd-MM-yyyy HH:mm:ss')
            ->hideOnForm()
        ;
        yield AssociationField::new('section')->setLabel('Раздел')->setRequired(true);
        yield AssociationField::new('author')->setLabel('Автор')->hideOnForm();
    }
}
