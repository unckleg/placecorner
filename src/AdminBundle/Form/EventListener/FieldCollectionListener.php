<?php

namespace AdminBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FieldCollectionListener implements EventSubscriberInterface
{
    const USERNAME = 'username';
    const PASSWORD = 'password';

    /**
     * @var Form $form
     */
    protected $form;

    /**
     * Tells the dispatcher that you want to listen on the form.pre_set_data
     * event and that the preSetData method should be called.
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    /**
     * When there is pre set data or Form is populated
     * Than we will with EventSubscriber rebuild wanted fields
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        $this->form = $event->getForm();
        $user = $event->getData();

        if ($user && $user->getId() !== null) {

            // username field rebuilding
            $username = $this->getField(self::USERNAME);
            $usernameOptions = $username->getOptions();
            $usernameOptions['attr']['readonly'] = '';
            $this->rebuildField($username, $usernameOptions);

            // password field rebuilding
            $password = $this->getField(self::PASSWORD);
            $passwordOptions = $password->getOptions();
            $passwordOptions['required'] = false;
            $this->rebuildField($password, $passwordOptions);

            //$this->buildErrorInputs();
        }
    }

    /**
     * @param FormBuilder $field
     * @param $options
     */
    protected function rebuildField(FormBuilder $field, $options)
    {
        $form = $this->form;
        $form->add($field->getName(), $field->typeName, $options);
    }

    /**
     * Returns object/array of data for provided fieldName
     * @param  $fieldName
     * @return FormBuilder $field
     */
    private function getField($fieldName)
    {
        $form  = $this->form;
        $field = $form->get($fieldName)->getConfig();
        $field->typeName = $this->getFieldTypeName($field);
        return $field;
    }

    /**
     * Return string of field type (TextType::class, PasswordType:class)
     * @param FormBuilder $field
     * @return null|string
     */
    private function getFieldTypeName(FormBuilder $field)
    {
        return get_class($field->getType()->getInnerType());
    }

//    /**
//     * Method used to build Form input error classes
//     * if there is error related to input
//     */
//    protected function buildErrorInputs()
//    {
//        $form   = $this->form;
//        $fields = $form->all();
//
//        foreach ($fields as $field) {
//            $fieldName   = $field->getName();
//            $fieldErrors = $form->get($fieldName)->getErrors();
//
//            if (!empty($fieldErrors)) {
//                $fieldOptions = $this->getField($fieldName)->getOptions();
//                $fieldAttrOpt = $fieldOptions['attr'];
//
//                if (isset($fieldAttrOpt)) {
//                    if (isset($fieldAttrOpt['class'])) {
//                        $fieldOptions['attr']['class'] = $fieldAttrOpt['class'] . ' has-error';
//                    } else {
//                        $fieldOptions['attr']['class'] = 'has-error';
//                    }
//                }
//
//                $this->rebuildField(
//                    $form->get($fieldName)->getConfig(),
//                    $fieldOptions
//                );
//            }
//
//        }
//    }
}