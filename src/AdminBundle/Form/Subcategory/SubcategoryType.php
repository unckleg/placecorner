<?php

namespace AdminBundle\Form\Subcategory;

use AdminBundle\Model\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubcategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parents = [];
        foreach ($options['parentCategories'] as $parent) {
            $parents[$parent['title']] = $parent['id'];
        }

        $builder
            ->add('title', TextType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_title_label',
                'attr'  => [
                    'class'       => 'form-control  input-lg',
                    'placeholder' => 'admin.module.subcategory.form.subcategory_title_placeholder'
                ]])
            ->add('description', TextareaType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.subcategory.form.subcategory_description_placeholder',
                    'rows'        => 6
                ]])
            ->add('seo_title', TextType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_seo_title_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.subcategory.form.subcategory_seo_title_placeholder'
                ]])
            ->add('seo_description', TextType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_seo_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.subcategory.form.subcategory_seo_description_placeholder'
                ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_seo_keywords_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.subcategory.form.subcategory_seo_keywords_placeholder'
                ]])
            ->add('image', FileType::class, [
                'label' => 'admin.module.subcategory.form.subcategory_image_label',
                'required'  => false
            ])
            ->add('parent_id', ChoiceType::class, [
                'attr'  => ['class' => 'form-control'],
                'choices' => $parents,
                'label' => 'admin.module.subcategory.form.subcategory_parent_label',
                'data' => $options['selectedCategory']
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
            'translation_domain' => 'admin',
            'parentCategories'   => null,
            'selectedCategory'   => null
        ]);
    }

    public function getName()
    {
        return 'subcategorycreate';
    }
}