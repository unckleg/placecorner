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
                'label' => 'admin.module.user.form.first_name_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.user.form.first_name_placeholder'
                ]])
            ->add('last_name', TextType::class, [
                'label' => 'admin.module.user.form.last_name_label',
                'required' => false,
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.user.form.last_name_placeholder'
                ]])
            ->add('username', TextType::class, [
                'label' => 'admin.module.user.form.username_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.user.form.username_placeholder'
                ]])
            ->add('email', EmailType::class, [
                'label' => 'admin.module.user.form.email_label',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'admin.module.user.form.email_placeholder'
                ]])
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'admin.module.user.form.password_invalid',
                    'required' => false,
                    'options'  => [
                        'attr' => ['class' => 'form-control', 'novalidate' => 'novalidate']
                    ],
                    'first_name'     => 'password',
                    'second_name'    => 'password_confirm',
                    'first_options'  => ['label' => 'admin.module.user.form.password_first_option'],
                    'second_options' => ['label' => 'admin.module.user.form.password_second_option'],
                    'required' => true,
                ])
            ->add('roles', ChoiceType::class, [
                'label' => 'admin.module.user.form.roles_label',
                'attr'  => ['class' => 'form-control'],
                'multiple' => true,
                'choices'  => [
                    'admin.module.user.form.roles_choices_label' => [
                        'admin.module.user.form.choices.super_admin' => 'ROLE_SUPER_ADMIN',
                        'admin.module.user.form.choices.admin'       => 'ROLE_ADMIN',
                        'admin.module.user.form.choices.moderator'   => 'ROLE_MODERATOR',
                        'admin.module.user.form.choices.editor'      => 'ROLE_EDITOR',
                        'admin.module.user.form.choices.author'      => 'ROLE_AUTHOR',
                        'admin.module.user.form.choices.visitor'     => 'ROLE_USER'
                    ]]
                ])
            ->add('save', SubmitType::class, [
                'label'   => 'admin.global.form.button_submit',
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
            'data_class' => User::class,
            'translation_domain' => 'admin'
        ]);
    }

    public function getName()
    {
        return 'usercreate';
    }
}