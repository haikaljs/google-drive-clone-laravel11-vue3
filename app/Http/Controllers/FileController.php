<?php

namespace App\Http\Controllers;

use App\Models\File;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFolderRequest;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function myFiles(){
        return Inertia::render('MyFiles');
    }

    // public function createFolder(StoreFolderRequest $request){

    //     $data = $request->validated();
    //     $parent = $request->parent;

    //     if(!$parent){
    //         $parent = $this->getRoot();
    //     }

    //     $file = new File();
    //     $file->is_folder = 1;
    //     $file->name = $data['name'];

    //     $parent->appendNode($file);

    // }

    public function createFolder(StoreFolderRequest $request)
{
    $data = $request->validated();
    $parent = $request->parent;

    // Determine the parent folder
    if (!$parent) {
        $parent = $this->getRoot();
    }

    // Ensure parent is not null
    if (!$parent) {
        return response()->json(['message' => 'Parent folder not found'], 404);
    }

    // Check if a folder with the same name exists under the same parent
    $existingFolder = File::where('parent_id', $parent->id)
        ->where('name', $data['name'])
        ->where('is_folder', 1)
        ->first();

    // if ($existingFolder) {
    //     return response()->json(['message' => 'A folder with this name already exists'], 422);
    // }

    if ($existingFolder) {
        // Manually add validation error
        $validator = Validator::make([], []); // Create an empty validator
        $validator->errors()->add('name', 'A folder with this name already exists.');

        throw new \Illuminate\Validation\ValidationException($validator);
    }

    // Create the new folder
    $file = new File();
    $file->is_folder = 1;
    $file->name = $data['name'];

    $parent->appendNode($file);

    // return response()->json(['message' => 'Folder created successfully']);
}

  


    public function getRoot(){
        return File::query()->whereIsRoot()->where('created_by', Auth::id())->firstOrFail();
    }
}
