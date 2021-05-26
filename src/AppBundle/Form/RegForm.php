<?php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.reg_form.email'],
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.reg_form.name'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'first_options'  => array('label' => false, 'attr' => ['placeholder' =>
                    'form_type.reg_form.pass']),
                'second_options' => array('label' => false, 'attr' => ['placeholder' =>
                    'form_type.reg_form.repeat_pass']),
            ])
            ->add('abc', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.reg_form.summ'],                
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
