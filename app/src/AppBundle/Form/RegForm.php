<?php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
            	'label' => false,
            	'attr' => ['placeholder' => 'email']
        	))
            ->add('username', TextType::class, array(
            	'label' => false,
            	'attr' => ['placeholder' => 'имя']
        	))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => false, 'attr' => ['placeholder' => 'пароль']),
                'second_options' => array('label' => false, 'attr' => ['placeholder' => 'повтор пароля']),
            ))
            ->add('abc', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'сумма двух чисел'],
                //'mapped' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}