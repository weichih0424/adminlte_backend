<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\DB;

class ImageSaveService
{
    public function save_to_s3_for_fileUpload($table, $destination_path, $image_file, $id = '',$col='image')
    {
        if(!$image_file){
            return $image_file;
        }
        //查詢是否為新增文章or編輯文章，判斷：文章id有無
        //不為空=有id
        if (!empty($id)) {
            $data_image = DB::table($table)->find($id)->$col;
            if($image_file != '[]'){
                //修改文章
                $image_file = json_decode($image_file)[0];
                
            }else{
                Storage::disk('local')->delete(str_replace('http://127.0.0.1:8000/', '', $data_image));
                return $image_file;
            }
            if ($image_file !== $data_image) {
                $image_file = storage_path('app/public/' . $table . '/' . $image_file);
                //修改圖片
                Storage::disk('local')->delete(str_replace('http://127.0.0.1:8000/', '', $data_image));
                $image_path = $this->save_to_s3($image_file,$destination_path);
                
                return $image_path;
            } else {
                //未修改圖片
                return $data_image;
            }
        //為空，無id
        } else {
            if($image_file != '[]'){
                //新增文章
                $image_file = storage_path('app/public/' . $table . '/' . json_decode($image_file)[0]);
            }else{
                return $image_file;
            }
            //新增文章
            $image_path = $this->save_to_s3($image_file,$destination_path);
            return $image_path;
        }
    }

    // public function save_to_s3_for_croppic($table, $destination_path, $image_file, $id = '',$col='image')
    // {
    //     $dirPath = storage_path('app/public/temp/');
    //     $outputPath = asset("/storage/temp");
        
    //     if(!$image_file){
    //         return $image_file;
    //     }

    //     if (!empty($id)) {
    //         $data_image = DB::table($table)->find($id)->$col;
    //         if ($image_file !== $data_image) {
    //             $image_file = str_replace($outputPath,$dirPath,$image_file);
    //             Storage::disk('s3')->delete(str_replace('https://cc.tvbs.com.tw/', '', $data_image));
    //             $image_path = $this->save_to_s3($image_file,$destination_path);
    //             return $image_path;
    //         } else {
    //             return $data_image;
    //         }
    //     } else {
    //         $image_file = str_replace($outputPath,$dirPath,$image_file);
    //         $image_path = $this->save_to_s3($image_file,$destination_path);
    //         return $image_path;
    //     }
    // }
    public function save_to_s3($image_file, $destination_path)
    {
        $image = ImageManagerStatic::make($image_file)->encode('jpg', 90);
        $filename = md5($image_file . time()) . '.jpg';
        Storage::disk('local')->put($destination_path . '/' . $filename, $image->stream());
        //"coco/uploads/CocoArticle/c898e5ca0c5d2de0198839f28fc26e3d.jpg"
        //"/Users/ericchou/web/adminlte_backend/storage/app/public/coco_article/625d3c346978c.jpg"

        $image_path = 'http://127.0.0.1:8000/'.'storage/' . $destination_path . '/' . $filename;
        //"http://127.0.0.1:8000/coco/uploads/CocoArticle/dac31e3b2254848d5afd6d23c3f4c6ec.jpg"
        // $image_path = $destination_path . '/' . $filename;
        // dd($image_path);
        return $image_path;
    }
}