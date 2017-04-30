<?php

namespace AdminBundle\Form\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'admin.module.category.form.category_title_label',
                'attr'  => [
                    'class'       => 'form-control  input-lg',
                    'placeholder' => 'admin.module.category.form.category_title_placeholder'
            ]])
            ->add('description', TextareaType::class, [
                'label' => 'admin.module.category.form.category_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.category.form.category_description_placeholder',
                    'rows'        => 6
            ]])
            ->add('seo_title', TextType::class, [
                'label' => 'admin.module.category.form.category_seo_title_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.category.form.category_seo_title_placeholder'
            ]])
            ->add('seo_description', TextType::class, [
                'label' => 'admin.module.category.form.category_seo_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.category.form.category_seo_description_placeholder'
            ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'admin.module.category.form.category_seo_keywords_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.category.form.category_seo_keywords_placeholder'
            ]])
            ->add('image', FileType::class, [
                'label' => 'admin.module.category.form.category_image_label',
                'required'  => false
            ])
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
        return 'categorycreate';
    }
}