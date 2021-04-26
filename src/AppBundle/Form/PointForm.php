<?php
namespace AppBundle\Form;

use AppBundle\Entity\Points;
use AppBundle\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Valid;

use AppBundle\Form\ImageForm;


class PointForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.admin_point.mark_title', 'maxlength' => 200]
            ))
            ->add('description', TextareaType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.admin_point.mark_descr', 'maxlength' => 1000]
            ))
            ->add('longitude', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.admin_point.long', "readonly22" => ""]
            ))
            ->add('latitude', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'form_type.admin_point.lat', "readonly22" => ""]
            ))
            ->add('year', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'form_type.admin_point.year',
                    'min' => 1830,
                    'max' => 2000
                ]
            ])
            ->add('rotation', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'form_type.admin_point.point_view',
                    'min' => 0,
                    'max' => 360
                ]
            ])
            ->add('tag', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'form_type.admin_point.tags',
                    'data-role' => 'tagsinput'
                ]
            ])
            ->add('images',  ImageForm::class, [
                'label' => 'form_type.admin_point.load_image',
                'constraints' => array(new Valid()),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Points::class,
        ));
    }
}