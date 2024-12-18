<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType implements CRUDTypeInterface {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('firstname')
            ->add('surname')
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                                   'data_class' => Student::class,
                               ]);
    }
}
