<?php

namespace AdminBundle\Form\Newsletter;

use AdminBundle\Model\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countryId', ChoiceType::class, [
                'label'   => 'admin.module.newsletter.form.country_label',
                'attr'    => [ 'class' => 'form-control'],
                'choices' => $this->flattenCountriesCollectionData($options['countries']),
                'data'    => $options['selectedCountry']
            ])
            ->add('email', EmailType::class, [
                'label' => 'admin.module.newsletter.form.email_label',
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'admin.module.newsletter.form.email_placeholder'
            ]])
            ->add('ip', TextType::class, [
                'label' => 'admin.module.newsletter.form.ip_label',
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'admin.module.newsletter.form.ip_placeholder'
            ]])
            ->add('useragent', TextType::class, [
                'label' => 'admin.module.newsletter.form.useragent_label',
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'admin.module.newsletter.form.useragent_placeholder'
            ]])
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
     *      - Name is the name of Country in this case
     *      - Value is ID of Country
     * @param $countries
     * @return array - Flattened arr data
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
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'admin',
            'countries'          => null,
            'selectedCountry'    => null
        ));
    }

    public function getName()
    {
        return 'newsletter_create';
    }
}
