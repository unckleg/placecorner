<?php

namespace FrontBundle\Form;


use AdminBundle\Model\Entity\Category;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Tag;
use App\CoreBundle\Model\Constants;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAttributes(['id' => 'search_form'])
            ->add('text', TextType::class, [
                'required'   => true,
                'attr'  => [
                    'class'       => 'form-control input-lg',
                    'placeholder' => 'front.module.index.map_form.input'
                ]])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'front.module.index.map_form.city_label',
                'attr'  => [ 'class' => 'form-control selectpicker' ],
                'placeholder'  => 'front.module.index.map_form.all_cities',
                'empty_data'   => null,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'front.module.index.map_form.category_label',
                'attr'  => [ 'class' => 'form-control selectpicker' ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.parentId IS NULL');
                },
                'placeholder'  => 'front.module.index.map_form.all_categories',
                'empty_data'   => null,
                'choice_label' => 'title',
                'multiple'     => false,
                'expanded'     => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary pull-right',
                    'data-ajax-response' => 'map',
                    'data-ajax-auto-zoom' => 1,
                ]
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
            'translation_domain' => 'front',
        ]);
    }

    public function getName()
    {
        return 'pagecreate';
    }
}