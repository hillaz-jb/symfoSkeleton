<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Publisher;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublisherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'publisher.index.table.name',
            ])
            ->add('directorName', TextType::class, [
                'label' => 'publisher.index.table.directorName',
            ])
            ->add('website', TextType::class, [
                'label' => 'publisher.index.table.website',
                'required' => false,
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'publisher.index.table.createdAt',
                'required' => false,
                'attr' => array(
                    'min' => date('1900-01-01'),
                    'max' => date('2040-01-01'),
                )
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'country.index.table.nationality',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('country')
                        ->orderBy('country.name', 'ASC');
                },
                'required' => false,
            ])
            /*->add('country', CountryFormType::class, [
                'required' => false,
                'attr' => [
                    'mapped' => false,
                ]
            ])*/
            ->add('submit', SubmitType::class, [
                'label' => 'common.button.submit',
                'attr' => [
                    'mapped' => false,
                    'class' => 'btn-success',
                ],
                'row_attr' => [
                    'class' => 'mb-3 text-center'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publisher::class,
            'translation_domain' => 'messages',
        ]);
    }
}
