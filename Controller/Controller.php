<?php


namespace App\Controller;


class Controller
{
    public function view($filePath, array $data = []){
        $output = NULL;
        if(file_exists($filePath)){
            extract($data);
            ob_start();
            require($filePath);
            $output = ob_get_clean();
        }
        print $output;
    }
}