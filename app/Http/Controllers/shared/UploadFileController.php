<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function upload_file()
    {
        // dd($_POST);
        $folder_dir = storage_path("/app/public/");
        $path = $_POST['folder'];
        $url_dir = url('storage/' . $path) . '/';
        if (!is_dir($folder_dir . $path . '/')) :
            mkdir($folder_dir . $path . '/');
        endif;

        $ext = explode(".", $_FILES["file_data"]["name"]);
        $size = (int)$_FILES["file_data"]["size"];
        $file_ext = array_pop($ext);
        $file_name = uniqid() . "." . $file_ext;

        //圖片驗證-特殊規則 //增加自訂規則 語法： 規則1|規則2:參數1,參數2...
        if (isset($_POST['verify']) && $_POST['verify'] != '') {
            $verify_type = explode('|', $_POST['verify']);
            foreach ($verify_type as $type) {
                //驗證規則 
                switch (explode(':',$type)[0]) {
                    case 'ratio':
                        list($width, $height) = getimagesize($_FILES["file_data"]["tmp_name"]);
                        if ($width != $height) {
                            $error = array(
                                "error" => '圖片比例需為1:1',
                            );
                            echo json_encode($error);
                            exit();
                        }
                        break;
                    case 'size':
                        $data = explode(',',explode(':',$type)[1]);
                        $width = (int)$data[0];
                        $height = (int)$data[1];
                        $img_info = getimagesize($_FILES["file_data"]["tmp_name"]);

                        if ((int)$img_info[0] !== $width && (int)$img_info[1] !== $height) {
                            $error = array(
                                "error" => '圖片尺寸不正確，需為('.$width.'x'.$height.')',
                            );
                            echo json_encode($error);
                            exit();
                        }
                        break;
                }
            }
        }

        //圖片驗證-共通
        $allowed_types = array("gif", "jpeg", "jpg", "png");
        $overwrite = true;
        $max_size = '2048000';

        if (in_array($file_ext, $allowed_types)) {
            if ($size > $max_size) {
                $error = array(
                    'error' =>  "檔案大小請勿超過 " . $max_size . " Bytes",
                );
                echo json_encode($error);
            } else if (in_array($file_ext, $allowed_types)) {
                if ($_FILES["file_data"]["error"] > 0) {
                    $error = array(
                        "error" => 'ERROR Return Code: ' . $_FILES["file_data"]["error"],
                    );
                } else {
                    $filename = $_FILES["file_data"]["tmp_name"];
                    move_uploaded_file($filename, $folder_dir . $path . '/' . $file_name);
                    $response = [
                        'initialPreview' => [
                            "<img style='max-height:160px; max-width: 100%;' src='" . $url_dir . $file_name . "' class='file-preview-image'>",
                        ],
                        'initialPreviewConfig' => [
                            [
                                'caption'   =>  $file_name,
                                'width'     =>  '120px',
                                'url'       =>  url("/shared/fileupload/delete_file"),
                                'key'       =>  $file_name,
                                "extra"     =>  [
                                    "folder" => $path
                                ]
                            ],
                        ],
                        'append' => true
                    ];
                    echo json_encode($response);
                }
            } else {
                $error = array(
                    'error' =>  "檔案格式錯誤",
                );
                echo json_encode($error);
            }
        }
    }
    
    public function delete_file()
    {
        echo json_encode([]);
    }
}
