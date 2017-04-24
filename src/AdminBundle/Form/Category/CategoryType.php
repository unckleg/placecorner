<?php

namespace AdminBundle\Form\Category;

use AdminBundle\Model\Entity\Category;
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
                'label' => 'Category Title',
                'attr'  => [
                    'class'       => 'form-control  input-lg',
                    'placeholder' => 'Insert Title for Category'
            ]])
            ->add('description', TextareaType::class, [
                'label' => 'Category Description',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Insert Description for Category',
                    'rows'        => 6
            ]])
            ->add('seo_title', TextType::class, [
                'label' => 'Category SEO Title',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Insert SEO Title for Category'
            ]])
            ->add('seo_description', TextType::class, [
                'label' => 'Category SEO Description',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Insert SEO Description for Category'
            ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'Category SEO Keywords',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Insert SEO Keywords for Category'
            ]])
            ->add('image', FileType::class, [
                'label' => 'Insert Category Image (IMG file)'
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
            'data_class' => Category::class,
            'translation_domain' => 'admin'
        ]);
    }

    public function getName()
    {
        return 'categorycreate';
    }
}