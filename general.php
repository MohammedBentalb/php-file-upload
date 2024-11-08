<?php

/**
 * This is a file upload approach that has been changed to handle images only,
   yet many things here are wrong or could go wrong.
 * Thus, the index approach is better in almost everything.
 * This upload function still could be used as a test 
*/
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_FILES['image']['error'] === 0 && $_FILES['image']['size'] > 0){
        $pureName = pathinfo($_FILES['image']['full_path'], PATHINFO_FILENAME);
        $filename = preg_replace('/[^a-zA-Z0-9]/', '', $pureName);
        
        $dirPath = __DIR__ . '/public/images/';
        if(!is_dir($dirPath)){
            mkdir($dirPath, '0777', true);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $dirPath .  $filename . '-' . time(). '.jpeg');
    }
}