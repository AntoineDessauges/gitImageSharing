<?php

namespace App\Http\Requests;

use App\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FileUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $album = Album::findOrFail($request->get("album"));
        return $album->user()->first()->id == \Auth::user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "file"=>"required|image",
            "album"=>"required|exists:albums,id"
        ];
    }
}
