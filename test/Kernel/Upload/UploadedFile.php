<?php

namespace App\Kernel\Upload;

class UploadedFile
{

    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $tmp_name,
        public readonly int $error,
        public readonly int $size,
    ) {
    }

    public function move(string $path, string $filename = null): string|false{
        $storagePath = $_SERVER['DOCUMENT_ROOT'] . "/public/storage/$path";
        if (! is_dir($storagePath)) {

            mkdir($storagePath, 0777, true);
        }
        $filename = $filename ?? $this->randomFileName();
        $imageInfo = getimagesize($this->tmp_name);

        if ($imageInfo !== false) {
            $filePath = "$storagePath/$filename";
            if (move_uploaded_file($this->tmp_name, $filePath)) {
                return "$path/$filename";
            }
        }
        return false;
    }

    private function randomFileName()
    {
        return md5(uniqid(rand(), true)) . ".{$this->getExtension()}";
    }

    public function getExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }
}