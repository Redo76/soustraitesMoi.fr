<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderHelper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadAvatar(UploadedFile $uploadedFile, SluggerInterface $slugger) :string
    {
        //On génère un nouveau nom de fichier
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $slugger->slug($safeFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            
            $this->uploadsPath."/avatar",
            $newFilename
        );

        return $newFilename;
    }

    public function uploadProjectImages(UploadedFile $uploadedFile, SluggerInterface $slugger) :string
    {
        //On génère un nouveau nom de fichier
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $slugger->slug($safeFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            
            $this->uploadsPath."/project_img",
            $newFilename
        );

        return $newFilename;
    }

}
