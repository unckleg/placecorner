<?php

namespace AdminBundle\EventListener;

use AdminBundle\Model\Entity\Gallery;
use AdminBundle\Model\Entity\Images;
use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Service\Upload\FileUploader;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class GalleryUploadListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FileUploader
     */
    private $uploader;


    public function __construct(EntityManager $em, FileUploader $uploader)
    {
        $this->em = $em;
        $this->uploader = $uploader;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $em      = $this->em;
        $request = $event->getRequest();
        $place   = $em->getRepository(Place::class)->find($request->get('placeId'));
        $image   = new Images();
        $file    = $event->getFile();
        Validator::isValid($place);

        $fileName = $this->uploader->upload($file, $place->getId(), FileUploader::BULK_PHOTOS);
        $image->setImage($fileName);
        $em->persist($image);
        $em->flush();
        $place->addImages($image);
        $em->flush();

        $response = $event->getResponse();
        $response['success'] = true;
        return $response;
    }
}