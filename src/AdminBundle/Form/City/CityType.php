<?php

namespace AdminBundle\Form\City;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region', ChoiceType::class, [
                'attr'  => ['class' => 'form-control'],
                'choices' => $this->flattenCountriesCollectionData($options['regions']),
                'label'   => 'admin.module.city.form.city_region_label',
                'data'    => $options['selectedRegion']
            ])
            ->add('name', TextType::class, [
                'label' => 'admin.module.region.form.region_name_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.region.form.region_name_placeholder'
            ]])
            ->add('map', TextType::class, [
                'label' => 'admin.module.region.form.region_map_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.region.form.region_map_placeholder'
            ]])
            ->add('seo_title', TextType::class, [
                'label' => 'admin.module.city.form.city_seo_title_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.city.form.city_seo_title_placeholder'
            ]])
            ->add('seo_description', TextType::class, [
                'label' => 'admin.module.city.form.city_seo_description_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.city.form.city_seo_description_placeholder'
            ]])
            ->add('seo_keywords', TextType::class, [
                'label' => 'admin.module.city.form.city_seo_keywords_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.city.form.city_seo_keywords_placeholder'
            ]])
            ->add('image', FileType::class, [
                'label' => 'admin.module.city.form.city_image_label',
                'required'  => false
            ])
            ->add('save', SubmitType::class, [
                'label'   => 'admin.global.form.button_submit',
                'attr'    => ['class' => 'btn blue'],
            ])
        ;
    }

    /**
     * Method used to parse and flatten countries doctrine array collection
     * to simple array for Symfony form factory builder:
     *      Name/Value:
     *      - Name is the name of Region in this case
     *      - Value is ID of Region
     * @param $regions
     * @return array - Flattened arr data
     */
    private function flattenCountriesCollectionData($regions)
    {
        $flattenedData = [];
        foreach ($regions as $region) {
            $flattenedData[$region['name']] = $region['id'];
        }

        return $flattenedData;
    }

    /**
     * @param OptionsResolver $resolver
     * @value See docs
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'admin',
            'regions'            => null,
            'selectedRegion'     => null
        ]);
    }

    public function getName()
    {
        return 'citycreate';
    }
}