<?php

namespace Sistema\MsjinternaBundle\Models;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploadFileMover {

    public function moveUploadedFile(UploadedFile $file, $uploadBasePath,$relativePath) {
        $originalName = $file->getClientOriginalName();
        $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
        $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
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

            $i = $i + 1;
            $j = $j + 1;
        }   
          
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
