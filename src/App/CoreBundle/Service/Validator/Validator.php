<?php

namespace App\CoreBundle\Service\Validator;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Validator implements Constants
{

    /**
     * Starter method checking is something valid
     * @param $data
     * @param $additionalCheck
     * @return bool
     * @throws \Exception
     */
    public static function isValid($data, $additionalCheck = null)
    {
        if (empty($data)) {
            throw new NotFoundHttpException('Provided data is empty.');
        };

        if (is_array($data)) {
            foreach ($data as $datas) {
                if (empty($datas)) {
                    throw new NotFoundHttpException('Provided data is empty. Data: ' . $datas);
                }
            }
        }

        if (isset($additionalCheck)) {
            if (!method_exists(new self(), $additionalCheck)) {
                $methods = implode(PHP_EOL, get_class_methods(self::class));
                throw new \Exception(
                    'Provided method: ' . $additionalCheck . 'not found. ' .
                    'List of all available methodes: ' . PHP_EOL . $methods);
            }

            if (is_array($data)) {
                foreach ($data as $datas) {
                    return self::$additionalCheck($datas) == self::VALID ? true : false;
                }
            } else {
                return self::$additionalCheck($data) == self::VALID ? true : false;
            }
        }

        return true;
    }

    /**
     * Check if passed data is type of string
     * @param  string $data
     * @return string
     */
    protected static function is_string($data)
    {
        if (is_string($data)) {
            return 'valid';
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'string'));
        }
    }

    /**
     * Check if passed data is type of array
     * @param  string $data
     * @return string
     */
    protected static function is_array($data)
    {
        if (is_array($data)) {
            return self::VALID;
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'array'));
        }
    }

    /**
     * Check if passed data is type of numeric
     * @param  string $data
     * @return string
     */
    protected static function is_numeric($data)
    {
        if (is_numeric($data)) {
            return self::VALID;
        } elseif ($data <= 0) {
            throw new Exception('Provided data is not valid or is below zero. Data: ' . $data);
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'numeric'));
        }
    }

    /**
     * Check if passed data is type of boolean
     * @param  string $data
     * @return string
     */
    protected static function is_boolean($data)
    {
        if (is_boolean($data)) {
            return self::VALID;
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'boolean'));
        }
    }

    /**
     * Check if passed data is file
     * @param  string $data
     * @return string
     */
    protected static function is_file($data)
    {
        if (is_file($data)) {
            return self::VALID;
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'file'));
        }
    }

    /**
     * Check if passed data is directory
     * @param  string $data
     * @return string
     */
    protected static function is_dir($data)
    {
        if (is_dir($data)) {
            return self::VALID;
        } else {
            throw new Exception(sprintf(self::NOT_VALID, 'directory'));
        }
    }

}