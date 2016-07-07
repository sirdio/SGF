<?php

namespace Sistema\FotocopiadoraBundle\Models;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of UploadFileMover
 *
 * @author Manoj
 */
class UploadFileMover {

    public function moveUploadedFile(UploadedFile $file, $uploadBasePath,$relativePath) {
        $originalName = $file->getClientOriginalName();//$file->getFilename();//
        // use filemtime() to have a more determenistic way to determine the subpath, otherwise its hard to test.
       // $relativePath = date('Y-m', filemtime($file->getPath()));
        $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
        $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
//        $ext = $file->getExtension();
//        
//        $i=1;
//        print_r(file_exists($targetFilePath)."###".$targetFilePath);
//        die();
        $i=1;
        while(file_exists($targetFilePath)){
            $valor =$i.".";
            if($i == 1){
                $ext1 = str_replace(".", $valor, $originalName);
                $j = 0;
            }else{
                $valor1 = $j.".";
                $ext1 = str_replace($valor1, $valor, $originalName);
                
            }
            $originalName = $ext1;
            $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
            $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
//        print_r($originalName);
//        echo "<br";
//        print_r($targetFilePath."#########");
//        die();
            $i = $i + 1;
            $j = $j + 1;
        }   
          
//        $ext = $file->getExtension();
//        $i=1;
//        while (file_exists($targetFilePath) && md5_file($file->getPath()) != md5_file($targetFilePath)) {
//            if ($ext) {
//                $prev = $i == 1 ? "" : $i;
//                $targetFilePath = $targetFilePath . str_replace($prev . $ext, $i++ . $ext, $targetFilePath);
//                print_r($targetFilePath."--"."primera condicion");
//                die();
//            } else {
//                $targetFilePath = $targetFilePath . $i++;
//                print_r($targetFilePath."--"."segunda condicion");
//                die();
//            }
//
//        }


        $targetDir = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath;
              
        if (!is_dir($targetDir)) {
            $ret = mkdir($targetDir, umask(), true);
          
            if (!$ret) {
                throw new \RuntimeException("No se pudo crear el directorio de destino para mover el archivo temporal en.");
            }
        }
        $file->move($targetDir, basename($targetFilePath));

        return str_replace($uploadBasePath . DIRECTORY_SEPARATOR, "", $targetFilePath);
        
    }
    
}

?>
