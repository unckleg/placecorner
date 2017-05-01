<?php

namespace AdminBundle\Form\Country;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'admin.module.country.form.country_name_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.country.form.country_name_placeholder'
            ]])
            ->add('map', TextType::class, [
                'label' => 'admin.module.country.form.country_map_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.country.form.country_map_placeholder'
            ]])
            ->add('save', SubmitType::class, [
                'label'   => 'admin.global.form.button_submit',
                'attr'    => ['class' => 'btn blue'],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     * @value See docs
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'admin'
        ]);
    }

    public function getName()
    {
        return 'countrycreate';
    }
}