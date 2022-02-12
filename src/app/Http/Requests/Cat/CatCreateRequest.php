<?php

namespace App\Http\Requests\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;


class CatCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:256",
            "description" => "required|string|max:1024",
            "birth" => "required|date",
            "image" => "nullable|image"
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        $all = parent::validationData();

        if (array_key_exists("image", $all)) {
            $all['image'] = $this->base64ToFile($all['image']);
        }

        return $all;
    }

    /**
     * create a file from base64 string, and save that file into temp directory.
     *
     * @param string $base64
     * @return null|UploadedFile
     */
    private function base64ToFile(string $base64): UploadedFile|null
    {
        $base64string = preg_replace("/^data:\w+\/\w+;base64,/", "", $base64);
        $content = base64_decode($base64string);

        // get file ext
        preg_match("/^data:\w+\/(\w+);base64,/", $base64, $matches);

        // temp directory
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString() . "." . $matches[1];

        // save as a file
        file_put_contents($tmpFilePath, $content);
        $tmpFile = new File($tmpFilePath);

        return new UploadedFile($tmpFile->getPathname(), $tmpFile->getFilename(), $tmpFile->getMimeType(), 0, true);
    }
}
