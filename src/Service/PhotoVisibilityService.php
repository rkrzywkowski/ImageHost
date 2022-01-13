<?php

namespace App\Service;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PhotoVisibilityService
{
    private $photoRepository;
    private $security;
    private $entityManager;

    public function __construct(PhotoRepository $photoRepository, Security $security, EntityManagerInterface $entityManager)
    {
        $this->photoRepository = $photoRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function makeVisibility(int $id, bool $visibility)
    {
        $em = $this->entityManager;
        $photo = $this->photoRepository->find($id);

        if($this->isPhotoBelongToCurrentUser($photo)){
            $photo->setIsPublic($visibility);
            $em->persist($photo);
            $em->flush();
            return true;
        } else {
            return false;
        }
    }

    private function isPhotoBelongToCurrentUser(Photo $photo)
    {
        if($photo->getUser() === $this->security->getUser()){
            return true;
        } else {
            return false;
        }
    }

}