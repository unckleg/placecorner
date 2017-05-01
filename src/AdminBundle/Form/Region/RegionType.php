<?php

namespace AdminBundle\Form\Region;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', ChoiceType::class, [
                'attr'  => ['class' => 'form-control'],
                'choices' => $this->flattenCountriesCollectionData($options['countries']),
                'label'   => 'admin.module.region.form.region_country_label',
                'data'    => $options['selectedCountry']
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
            ->add('save', SubmitType::class, [
                'label'   => 'admin.global.form.button_submit',
                'attr'    => ['class' => 'btn blue'],
            ])
        ;
    }

    /**
     * Method used to parse and flatten countries doctrine array collection
     * to simple array for symfony form factory builder:
     *      Name/Value:
     *      - Name is the name of Country in this case
     *      - Value is ID of Country
     * @param $countries
     * @return array | Flattened Data
     */
    private function flattenCountriesCollectionData($countries)
    {
        $flattenedData = [];
        foreach ($countries as $country) {
            $flattenedData[$country['name']] = $country['id'];
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
            'countries'          => null,
            'selectedCountry'    => null
        ]);
    }

    public function getName()
    {
        return 'regioncreate';
    }
}