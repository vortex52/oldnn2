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

use AppBundle\Form\ImageForm;


class PointForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'заголовок метки']
            ))
            ->add('description', TextareaType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'описание метки']
            ))
            ->add('longitude', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'координаты широты']
            ))
            ->add('latitude', TextType::class, array(
                'label' => false,
                'attr' => ['placeholder' => 'координаты долготы']
            ))
            ->add('year', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'год',
                    'min' => 1800,
                    'max' => 2000,
                    'step' => 10
                ]
            ])
            ->add('rotation', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'направление съемки',
                    'min' => 0,
                    'max' => 360
                ]
            ])
            // ->add('image', EntityType::class, [
            //     'class' => Image::class,
            //     'choice_label' => 'image',
            // ])
            ->add('image',  ImageForm::class, [
                'mapped' => false,
                'label' => "Загрузите ваше изображение"
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