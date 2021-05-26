<?php
namespace AppBundle\Form;

use AppBundle\Entity\Points;
use AppBundle\Form\ImageForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class AdminPointForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.admin_point.mark_title', 'maxlength' => 200],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.admin_point.mark_descr', 'maxlength' => 1000],
            ])
            ->add('longitude', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.admin_point.long', 'readonly22' => ''],
            ])
            ->add('latitude', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'form_type.admin_point.lat', 'readonly22' => ''],
            ])
            ->add('year', null, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'form_type.admin_point.year',
                    'min'         => 1830,
                    'max'         => 2000,
                ],
            ])
            ->add('rotation', null, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'form_type.admin_point.point_view',
                    'min'         => 0,
                    'max'         => 360,
                ],
            ])
            ->add('tag', null, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'form_type.admin_point.tags',
                    'data-role'   => 'tagsinput',
                ],
            ])
            ->add('image', CollectionType::class, [
                'entry_type'  => ImageForm::class,
                'required'    => false,
                'label'       => false,
                'constraints' => array(new Valid()),
            ])
            ->add('enable', null, [
                'label' => 'enable',
                'attr'  => [
                    'class' => 'mb-3',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Points::class,
        ]);
    }
}
