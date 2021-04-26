<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_email', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.login.email']
            ))
            ->add('_password', PasswordType::class,  array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.login.pass']
            ))
            ->add('_remember_me', CheckboxType::class, [
                'label'    => 'form_type.login.remember_me',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}