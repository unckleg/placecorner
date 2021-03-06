<?php

namespace AdminBundle\Form\Place;

use AdminBundle\Model\Entity\Category;
use AdminBundle\Model\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAttributes(['id' => 'place_form'])
            ->add('title', TextType::class, [
                'label' => 'admin.module.place.form.title_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'required'   => true,
                'attr'  => [
                    'class'       => 'form-control input-lg',
                    'placeholder' => 'admin.module.place.form.title_placeholder'
            ]])
            ->add('content', TextareaType::class, [
                'label' => 'admin.module.place.form.content_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class' => 'form-control',
                    'id'    => 'content',
                    'cols'  => 6
            ]])
//            ->add('gallery_id', ChoiceType::class, [
//                'attr'    => ['class' => 'form-control'],
//                'choices' => $this->flattenCollectionData($options['galleries']),
//                'label'   => 'admin.module.place.form.gallery_label',
//                'data'    => $options['selectedGallery']
//            ])
            ->add('map', TextType::class, [
                'label' => 'admin.module.place.form.map_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.map_placeholder'
            ]])
            ->add('working_hours', TextType::class, [
                'label' => 'admin.module.place.form.working_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.working_placeholder'
            ]])
            ->add('address', TextType::class, [
                'label' => 'admin.module.place.form.address_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.address_placeholder'
            ]])
            ->add('phone', NumberType::class, [
                'label' => 'admin.module.place.form.phone_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.phone_placeholder'
            ]])
            ->add('email', EmailType::class, [
                'label' => 'admin.module.place.form.email_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.email_placeholder'
            ]])
            ->add('website', UrlType::class, [
                'label' => 'admin.module.place.form.website_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.website_placeholder'
            ]])
            ->add('social_facebook', TextType::class, [
                'label' => 'admin.module.place.form.facebook_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.facebook_placeholder'
            ]])
            ->add('social_youtube', TextType::class, [
                'label' => 'admin.module.place.form.youtube_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.youtube_placeholder'
            ]])
            ->add('social_instagram', TextType::class, [
                'label' => 'admin.module.place.form.instagram_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.instagram_placeholder'
            ]])
            ->add('social_twitter', TextType::class, [
                'label' => 'admin.module.place.form.twitter_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.twitter_placeholder'
            ]])
            ->add('seo_title', TextType::class, [
                'label' => 'admin.module.place.form.page_seo_title_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.page_seo_title_placeholder'
            ]])
            ->add('seo_description', TextType::class, [
                'label' => 'admin.module.place.form.page_seo_description_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.page_seo_description_placeholder'
            ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'admin.module.place.form.page_seo_keywords_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.place.form.page_seo_keywords_placeholder'
            ]])
            ->add('image', FileType::class, [
                'label' => 'admin.module.place.form.place_image_label',
                'required'  => false
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'label' => 'admin.module.place.form.tag_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [ 'class' => 'form-control' ],
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'admin.module.place.form.category_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'  => [ 'class' => 'form-control' ],
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('city', ChoiceType::class, [
                'label'   => 'admin.module.place.form.city_label',
                'label_attr' => ['class' => 'control-label col-md-3 col-sm-6 col-xs-6 text-right'],
                'attr'    => ['class' => 'form-control'],
                'choices' => $this->flattenCollectionData($options['cities']),
                'data'    => $options['selectedCity']
            ])
        ;
    }

    /**
     * Method used to parse and flatten doctrine array collection
     * to simple array for Symfony form factory builder:
     * @param $options
     * @return array - Flattened arr data
     */
    private function flattenCollectionData($options)
    {
        $flattenedData = [];
        foreach ($options as $option) {
            $flattenedData[$option['name']] = $option['id'];
        }
        return $flattenedData;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'admin',
            'error_bubbling'     => true,
            'cities'             => null,
            'constraints'        => new Valid(),
            'galleries'          => null,
            'selectedCity'       => null,
            'selectedGallery'    => null
        ]);
    }

    public function getName()
    {
        return 'pagecreate';
    }

}
