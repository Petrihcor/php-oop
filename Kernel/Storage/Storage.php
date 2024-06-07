<?php

namespace App\Kernel\Storage;

class Storage
{

    public function __construct()
    {
    }

    public function url(string $path): string{

        return "https://test.local/public/storage/$path";
    }
    public function get(string $path): string{
        return file_get_contents($this->storagePath($path));
    }
    private function storagePath(string $path) {
        return $_SERVER['DOCUMENT_ROOT'] . "/public/storage/$path";
    }
}