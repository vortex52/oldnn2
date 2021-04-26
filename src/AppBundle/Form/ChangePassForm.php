<?php
namespace AppBundle\Form;

use AppBundle\Entity\Changepass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangePassForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder           
            ->add('oldPassword', PasswordType::class, array(
            	'label' => false,
            	'attr' => ['placeholder' => 'form_type.change_pass.old_pass']
        	))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => false, 'attr' => 
                    ['placeholder' => 'form_type.change_pass.new_pass']),
                'second_options' => array('label' => false, 'attr' => 
                    ['placeholder' => 'form_type.change_pass.repeat_pass']),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Changepass::class,
        ));
    }
}