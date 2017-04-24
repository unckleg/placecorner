<?php


namespace AdminBundle\Twig;


use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Yaml\Yaml;

class LibrariesExtension extends \Twig_Extension
{
    const EXT_JS  = '.js';
    const EXT_CSS = 'css';

    /**
     * Symfony Container
     * @var Container $container
     */
    protected $container = null;
    protected $fileType  = null;

    protected $options;
    protected $isCached;
    protected $cache;

    /**
     * LibrariesExtension constructor.
     * @param Container $container
     * @param array|null $options
     */
    public function __construct(Container $container, array $options = null)
    {
        $this->container = $container;
        $this->options   = $container->getParameter('libraries_extension');
    }

    /**
     * @param $libraries
     * @throws \Exception
     * @return mixed
     */
    public function find($libraries, $type = self::EXT_JS)
    {
        if (Validator::isValid($libraries)) {
            $this->fileType  = $type;
            $options   = $this->options;
            $container = $this->container;

            foreach ($options['bundles'] as $bundleName => $bundleOptions) {
                $librariesFile = $bundleName . $bundleOptions['path'] .'/'. $bundleOptions['file'];
                $kernel = $container->get('kernel');
                $path   = $kernel->locateResource('@'.$librariesFile);

                if (file_exists($path)) {
                    return $this->load($path, $libraries);
                } else {
                    throw new \Exception('Libraries file path or name is not provided in config.yml file.');
                }
            }

        }
    }

    /**
     * Validating and parsing yaml libraries factory if same exist.
     * @param $librariesFile
     * @param $libraries
     * @return mixed
     */
    protected function load($librariesFile, $libraries)
    {
        $libraryData = Yaml::parse(file_get_contents($librariesFile));
        $libraryName = $libraries;

        if (is_string($libraryName)) {
            $librariesToCompile = $libraryData['libraries'][$libraryName];
        } elseif (is_array($libraryName)) {
            $librariesToCompile = [];
            foreach ($libraryName as $library) {
                $librariesToCompile[] = $libraryData['libraries'][$library];
            }
        }

        return $this->compile($librariesToCompile);
    }

    /**
     * Compile libraries into js or css tags and serve it as output
     * @param $libraries
     * @return mixed
     */
    protected function compile($libraries)
    {
        $javascripts = [];
        $stylesheets = [];

        if (is_array($libraries)) {
            $libraries = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($libraries));
            foreach ($libraries as $library) {
                $libraryType = substr($library, -3);
                if ($libraryType == self::EXT_CSS) {
                    $stylesheets[] = "<link href='".$library."' rel='stylesheet' type='text/css'/>";
                } elseif($libraryType == self::EXT_JS) {
                    $javascripts[] = "<script src='".$library."' type='text/javascript' ></script>";
                }
            }
        } else {
            $libraryType = substr($libraries, -3);
            if ($libraryType == self::EXT_CSS) {
                $stylesheets[] = "<link href='".$libraries."' rel='stylesheet' type='text/css'/>";
            } elseif($libraryType == self::EXT_JS) {
                $javascripts[] = "<script src='".$libraries."' type='text/javascript' ></script>" ;
            }
        }

        return ($this->fileType == str_replace('.', '', self::EXT_JS)) ?
            implode(PHP_EOL, $javascripts) :
            implode(PHP_EOL, $stylesheets)
        ;
    }


    protected function serve(){}
    protected function getCache(){}
    protected function isCached(){}
    private function   setCache(){}

    /**
     * Twig getFunctions read docs for more info.
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('loadLibraries', [$this, 'find']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'libraries';
    }
}