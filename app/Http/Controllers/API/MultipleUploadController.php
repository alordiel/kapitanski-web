<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Http\Request;

class MultipleUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {

        $validatedData = $request->validate([
            'type' => 'required',
            'image' => 'required',
            File::types(['jpeg', 'pdf', 'png'])->max(4 * 1024)
        ]);

        $typeFolder = $request->input('type');
        $file = $request->file('image');

        $path = $file->store('public/images/' . $typeFolder);
        $name = $file->getClientOriginalName();

        //store image file into directory and db
        $image = new Image();
        $image->title = $name;
        $image->path = $path;
        $image->alt = '';
        $image->type = $typeFolder;
        $image->save();

        return response()->json([
            'status' => 1,
            'id' => $image->id,
            'url' => $image->path,
        ], 200);
    }
}
