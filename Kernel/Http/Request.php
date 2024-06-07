<?php

namespace App\Kernel\Http;

use App\Kernel\Upload\UploadedFile;
use App\Kernel\Validator\Validator;

class Request
{
    private Validator $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $files,
        public readonly array $cookies
    ){

    }
    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }

    public function validate(array $rules): bool {
        $data = [];
        foreach ($rules as $field => $rule) {
            $data[$field] = $this->input($field);
        }
        return $this->validator->validate($data, $rules);
    }
    public function errors(): array
    {
        return $this->validator->errors();
    }

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_SERVER,
            $_FILES,
            $_COOKIE
        );
    }

    public function uri(): string {
        return strtok(trim($this->server['REQUEST_URI'], '/'),'?');
    }

    public function method(): string {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null): mixed {

        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }
    public  function file(string $key): ?UploadedFile
    {
        if (! isset($this->files[$key])) {
            return null;
        }
        return new UploadedFile(
            $this->files[$key]['name'],
            $this->files[$key]['type'],
            $this->files[$key]['tmp_name'],
            $this->files[$key]['error'],
            $this->files[$key]['size'],
        );
    }

}
