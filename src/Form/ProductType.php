<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Name',
                'required' => true,
                'attr'=> [
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class,[
                'label'=>'Description',
                'attr'=> [
                    'class' => 'form-control',
                ],
            ])
            ->add('price', NumberType::class,[
                'label'=> 'Price',
                'attr'=> [
                    'class' => 'form-control',
                ],
            ])
            ->add('quantity', NumberType::class,[
                'label' => 'Quantity',
                'attr'=> [
                    'class' => 'form-control',
                ],
            ])
            ->add('soldPrice',NumberType::class,[
                'label' => ' Sold Price',
                'required' => false,
                'attr'=> [
                    'class' => 'form-control',
                ],
            ])           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
