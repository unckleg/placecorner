<?php

namespace App\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class CoreController extends Controller
{
    /**
     * Constant TRANS_FORMAT used as default translation catalogues format
     */
    const TRANS_FORMAT = 'yaml';

    /**
     * @param  $translationKey
     * @param  array $arr
     * @param  string $domain
     * @return Translator
     */
    public function trans($translationKey, array $arr, $domain)
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        $format  = self::TRANS_FORMAT;
        $locale  = $request->getLocale();

        $fileLocator = $this->get('file_locator');
        $pathAdmin   = $fileLocator->locate('@AdminBundle/Resources/translations/' . $domain .'.'. $locale . '.yml');
        $pathFront   = $fileLocator->locate('@FrontBundle/Resources/translations/' . $domain .'.'. $locale . '.yml');

        $translator = new Translator($locale, new MessageSelector());
        $translator->addLoader($format, new YamlFileLoader());
        $translator->addResource($format, $pathAdmin, $locale, $domain);
        $translator->addResource($format, $pathFront, $locale, $domain);

        return $translator->trans($translationKey, $arr, $domain);
    }
}
