<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'логин']
            ))
            ->add('_password', PasswordType::class,  array(
                'label' => false,
                'attr' => ['placeholder' => 'пароль']
            ))
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}