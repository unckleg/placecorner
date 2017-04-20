<?php

namespace AdminBundle\Form\User;

use AdminBundle\Entity\User;
use AdminBundle\Form\EventListener\FieldCollectionListener;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'First Name',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter users first name'
                ]])
            ->add('last_name', TextType::class, [
                'label' => 'Last Name',
                'required' => false,
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter users last name'
                ]])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Username used when user acess administration'
                ]])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter email for this user'
                ]])
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'required' => false,
                    'options'  => [
                        'attr' => ['class' => 'form-control', 'novalidate' => 'novalidate']
                    ],
                    'first_name'     => 'password',
                    'second_name'    => 'password_confirm',
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                    'required' => true,
                ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Pick Role For User',
                'attr'  => ['class' => 'form-control'],
                'multiple' => true,
                'choices'  => [
                    'Select role for this user' => [
                        'Super Admin'   => 'ROLE_SUPER_ADMIN',
                        'Administrator' => 'ROLE_ADMIN',
                        'Moderator'     => 'ROLE_MODERATOR',
                        'Editor'        => 'ROLE_EDITOR',
                        'Author'        => 'ROLE_AUTHOR',
                        'Visitor'       => 'ROLE_USER'
                    ]]
                ])
            ->add('save', SubmitType::class, [
                'label'   => 'Submit',
                'attr'    => ['class' => 'btn blue'],
                ])
        ;

        // If form is populated with Entity data add "disabled" to username field
        $builder->addEventSubscriber(new FieldCollectionListener());
    }

    /**
     * @param OptionsResolver $resolver
     * @value See docs
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getName()
    {
        return 'usercreate';
    }
}