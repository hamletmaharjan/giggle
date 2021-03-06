<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use File;


/**
 * 
 */
class ImageServices{
	protected $imageIntervention;
	

	public function moveImageWithName($data){
		$imageName = time().'.'.$data->getClientOriginalExtension();
        // $data->move(public_path('/uploads/articles'),$imageName);
        $path = $data->storeAs('public/articles',$imageName);
		return $imageName;
    }
    
    public function deleteArticle($imageName){
        //$image_path = public_path()."/uploads/articles/".$imageName;  // Value is not URL but directory file path
        // if(File::exists($image_path)) {
        //     File::delete($image_path);
        // }
        Storage::delete('public/articles/'.$imageName);
        return true;
    }
}