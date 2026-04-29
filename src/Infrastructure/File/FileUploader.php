<?php

namespace Infrastructure\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'pdf'];
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'application/pdf'];
    private const MAX_SIZE = 5 * 1024 * 1024; // 5MB

    public function __construct(private string $targetDirectory)
    {
    }

    public function upload(UploadedFile $file): array
    {
        if ($file->getSize() > self::MAX_SIZE) {
            throw new \InvalidArgumentException('Le fichier est trop volumineux (max 5Mo)');
        }

        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            throw new \InvalidArgumentException('Type de fichier non autorisé. Autorisé : JPG, PNG, PDF');
        }

        $extension = $file->guessExtension();
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new \InvalidArgumentException('Extension de fichier non autorisée');
        }

        $originalName = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();

        $fileName = uniqid() . '.' . $extension;
        $datePath = date('Y/m');
        $uploadDir = $this->targetDirectory . '/' . $datePath;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file->move($uploadDir, $fileName);

        return [
            'nom' => $originalName,
            'url' => '/uploads/' . $datePath . '/' . $fileName,
            'mime' => $mime,
            'taille' => $size
        ];
    }
}
