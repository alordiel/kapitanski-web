<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Http\Request;

class MultipleUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'type' => 'required',
            'image' => 'required',
            File::types(['jpeg', 'pdf', 'png'])->max(4 * 1024)
        ]);

        $file = $request->file('image');
        $type = $request->input('type');
        $name = $file->getClientOriginalName();
        $hashedName = $file->hashName();
        $file->move(public_path('images/' . $type), $hashedName);
        $url = 'images/' . $type . '/' . $hashedName;

        //store image file into directory and db
        $image = new Image();
        $image->title = $name;
        $image->path = $url;
        $image->alt = '';
        $image->type = $request->input('type');
        $image->save();

        return response()->json([
            'status' => 1,
            'id' => $image->id,
            'url' => $url,
        ], 200);
    }
}
