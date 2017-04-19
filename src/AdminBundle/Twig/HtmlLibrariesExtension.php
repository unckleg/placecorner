<?php

namespace AdminBundle\Twig;

use Symfony\Component\Config\Definition\Exception\Exception;

class HtmlLibrariesExtension extends \Twig_Extension
{
    const CSS = 'css';
    const JS  = 'js';

    /**
     * Twig getFunctions read docs for more info.
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('loadLibrary', array($this, 'load')),
        );
    }

    /**
     * Returns library by provided name
     * If not library returns null
     * @param string $library
     * @param string $fileType
     * @return mixed
     */
    public function load($library, $fileType = self::CSS)
    {
        if (is_string($library) || is_array($library)) {
            return $this->make($library, $fileType);
        } else {
            throw new Exception('You must provide valid library index name. Example: datatable');
        }

    }

    /**
     * Building Js and Css output
     * @param string $library
     * @param string $fileType
     * @return null|string
     */
    private function make($library, $fileType)
    {
        if (is_array($library)) {
            $libs = [];
            foreach($library as $libraryIndex) {
                foreach($this->libs()[$libraryIndex] as $finnalLib) {
                    $libs[] = $finnalLib;
                }
            }
            $library = $libs;
        } else {
            $index   = $library;
            $library = $this->libs()[$index];
        }

        if (!empty($library)) {
            $javascripts = [];
            $stylesheets = [];
            // check resource type
            foreach ($library as $file) {
                $libraryType = substr($file, -3);
                if ($libraryType == self::CSS) {
                    $stylesheets[]  = "<link href='".$file."' rel='stylesheet' type='text/css'/>";
                } elseif ($libraryType == '.'.self::JS) {
                    $javascripts[] ="<script type='text/javascript' src='".$file."'></script>";
                }
            }

            $cssOutput = implode(PHP_EOL, $stylesheets);
            $jsOutput  = implode(PHP_EOL, $javascripts);

            if ($fileType == self::CSS) {
                return $cssOutput;
            } else {
                return $jsOutput;
            }
        }

        // if array empty return null
        return null;
    }

    /**
     * List of all libraries ready to be loaded
     * @return array
     */
    private function libs()
    {
        $libraries = [
            'datatable' => [
                '/skins/backend/assets/global/plugins/datatables/datatables.min.css',
                '/skins/backend/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                '/skins/backend/assets/global/scripts/datatable.js',
                '/skins/backend/assets/global/plugins/datatables/datatables.min.js',
                '/skins/backend/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
            ],
            'confirmation' => [
                '/skins/backend/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js',
                '/skins/backend/assets/pages/scripts/ui-confirmations.min.js',

            ]
        ];

        return $libraries;
    }

    public function getName()
    {
        return 'htmlLibraries';
    }
}