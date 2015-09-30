<?php

namespace SSFrame\Files;


class FileUpload {

    static public function postImage($file, $filename, $uploadDir, $isThumb = false, $width = 800, $uploadThumb = "", $widthThumb = 150){
        $destinationPath = $uploadDir;
        if(!file_exists($destinationPath))	mkdir($destinationPath, 0777);
        if($uploadThumb != "") {
            if (!file_exists($uploadThumb)) mkdir($uploadThumb, 0777);
        }
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = $filename.".".$extension;
        $uploadSuccess = "";
        if($extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "png" || $extension == "tiff"){
            $uploadSuccess1 = move_uploaded_file($file['tmp_name'], $destinationPath."/".$filename);
            if(! $uploadSuccess1){
                return;
            }

            if($isThumb === true){
                $uploadSuccess2 = copy($destinationPath."/".$filename, $uploadThumb."/".$filename);
            }

        }

        ImageResize::load($destinationPath."/".$filename);
        ImageResize::resizeToWidth($width);
        ImageResize::save();
        if($isThumb === true){
            ImageResize::load($uploadThumb."/".$filename);
            ImageResize::resizeToWidth($widthThumb);
            ImageResize::save();
        }
        return $filename;

    }

    static public function postSound($file, $destination, $filename){
        $destinationPath = $destination;
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $filename.".".$extension;
        $uploadSuccess = "";
        if($extension == "wav" || $extension == "mp3"){
            $uploadSuccess = $file->move($destinationPath, $filename);
        }

        if( $uploadSuccess ) {
            return array('filename' => $filename);
        } else {
            return false;
        }
    }

    static public function postPresentation($file, $destination, $filename){
        $destinationPath = $destination;
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $filename.".".$extension;
        $uploadSuccess = "";
        if($extension == "ppt" || $extension == "pps" || $extension == "pptx" || $extension == "ppsx"){
            $uploadSuccess = $file->move($destinationPath, $filename);
        }

        if( $uploadSuccess ) {
            return array('filename' => $filename);
        } else {
            return false;
        }
    }
}