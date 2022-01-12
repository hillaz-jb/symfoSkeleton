<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'account.index.table.name',
            ])
            ->add('email', TextType::class, [
                'label' => 'account.index.table.email',
            ])
            ->add('nickname', TextType::class, [
                'label' => 'account.index.table.nickname',
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
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            'translation_domain' => 'messages',
        ]);
    }
}
