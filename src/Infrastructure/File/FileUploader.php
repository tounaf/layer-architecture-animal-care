<?php

namespace Infrastructure\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function __construct(private string $targetDirectory)
    {
    }

    public function upload(UploadedFile $file): array
    {
        $fileName = uniqid() . '.' . $file->guessExtension();
        $datePath = date('Y/m');
        $uploadDir = $this->targetDirectory . '/' . $datePath;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file->move($uploadDir, $fileName);

        return [
            'nom' => $file->getClientOriginalName(),
            'url' => '/uploads/' . $datePath . '/' . $fileName,
            'mime' => $file->getClientMimeType(),
            'taille' => $file->getSize()
        ];
    }
}
