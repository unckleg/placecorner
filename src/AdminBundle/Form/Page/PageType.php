<?php

namespace AdminBundle\Form\Page;

use AdminBundle\Model\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'admin.module.page.form.page_title_label',
                'attr'  => [
                    'class'       => 'form-control  input-lg',
                    'placeholder' => 'admin.module.page.form.page_title_placeholder'
            ]])
            ->add('content', TextareaType::class, [
                'label' => 'admin.module.page.form.page_content_label',
                'attr'  => [
                    'class' => 'form-control',
                    'rows'  => '10',
                    'id'    => 'content'
            ]])
            ->add('seo_title', TextType::class, [
                'label' => 'admin.module.page.form.page_seo_title_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.page.form.page_seo_title_placeholder'
            ]])
            ->add('seo_description', TextType::class, [
                'label' => 'admin.module.page.form.page_seo_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.page.form.page_seo_description_placeholder'
            ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'admin.module.page.form.page_seo_keywords_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.page.form.page_seo_keywords_placeholder'
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
        return 'pagecreate';
    }
}