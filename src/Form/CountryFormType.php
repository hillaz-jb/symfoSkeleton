<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'country.index.table.name',
            ])
            ->add('nationality', TextType::class, [
                'label' => 'country.index.table.nationality',
            ])
            ->add('code', TextType::class, [
                'label' => 'country.index.table.code',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'common.button.submit',
                'attr' => [
                    'mapped' => false,
                    'class' => 'btn-success'
                ],
                'row_attr' => [
                    'class' => 'mb-3 text-center'
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Country::class,
            'translation_domain' => 'messages',
        ]);
    }
}
