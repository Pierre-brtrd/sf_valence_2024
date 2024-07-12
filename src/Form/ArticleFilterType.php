<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\User;
use App\Filter\ArticleFilter;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un article...'
                ],
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'class' => Categorie::class,
                'required' => false,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (CategorieRepository $repo): QueryBuilder {
                    return $repo->createQueryBuilder('c')
                        ->andWhere('c.enable = true')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('authors', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => User::class,
                'choice_label' => 'fullName',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (UserRepository $repo): QueryBuilder {
                    return $repo->createQueryBuilder('u')
                        ->join('u.articles', 'a')
                        ->orderBy('u.lastName', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleFilter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
