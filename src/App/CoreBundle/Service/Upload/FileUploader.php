<?php

namespace App\CoreBundle\Service\Upload;

use AdminBundle\Model\Entity\Place;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    const FEATURED_PHOTO = '/featured';
    const BULK_PHOTOS    = '/images';

    private $targetDir;

    /**
     * FileUploader constructor.
     * @param $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param  $file
     * @param  Place        $placeId
     * @param  string       $type
     * @return string
     */
    public function upload(
        $file,
        $placeId = null,
        $type    = self::FEATURED_PHOTO)
    {
        $fs = new Filesystem();

        if (empty($placeId)) {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->targetDir, $fileName);
            return $fileName;
        }

        $placePath = $this->targetDir .'/'. $placeId . $type;
        if ($type == self::FEATURED_PHOTO) {
            $fileName  = 'featured' .'.'. $file->guessExtension();
        } else {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
        }

        try {
            if (is_dir($placePath)) {
                if (file_exists($fileName))  {
                    unlink($placePath .'/'. $fileName);
                }
                $file->move($placePath, $fileName);
            } else {
                $fs->mkdir($placePath);
                $file->move($placePath, $fileName);
            }
            return $fileName;
        } catch (IOException $e) {
            echo "An error occurred while creating your directory at " . $e->getPath();
        }
    }

    /**
     * @return mixed
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }
}