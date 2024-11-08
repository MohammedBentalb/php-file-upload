<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

date_default_timezone_set('Africa/Casablanca');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $allowedTypes = [
            IMAGETYPE_JPEG => 'jpeg',
            IMAGETYPE_PNG => 'png'
    ];

    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0 && $_FILES['image']['size'] > 0 && array_key_exists(exif_imagetype($_FILES['image']['tmp_name']), $allowedTypes)){

        // sanitize filename and removing extension for the sake of security
        $pureName = pathinfo($_FILES['image']['full_path'], PATHINFO_FILENAME);
        $newFilename = preg_replace('/[^a-zA-Z0-9]/', '', $pureName) . '-' . time();
        
        // Creating the directory if not already existed 
        $uploadDir = __DIR__ . '/public/images/';
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Getting image dimensions
        $imagePath = $_FILES['image']['tmp_name'];
        $imageSize = getimagesize($imagePath);
        if(!empty($imageSize)){ 
            [$width, $height] = $imageSize;
            // Setting the max dimension to be 500 (randomly picked number but could be modified depending on the frond-end needs) and calculating the scale factor + new width and height
            $maxDim = 500;
            $scaleFactor = (float) ($maxDim / max($width, $height));
            $newWidth = (float) ($width * $scaleFactor);
            $newHeight = (float) ($height * $scaleFactor);
            // Getting the image type
            $imageType = exif_imagetype($imagePath);
            // Making functions depending on the type
            $createFunc = "imagecreatefrom{$allowedTypes[$imageType]}";
            $saveFunc = "image{$allowedTypes[$imageType]}";
            // Creating the image from path and the new resized image holder
            $image = $createFunc($imagePath);
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            if(!empty($newImage)){
                // Maintaining the transparency (alpha) of png images
                if($imageType === IMAGETYPE_PNG){
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                }
                // Resizing and saving new image
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $saveFunc($newImage, $uploadDir . $newFilename . '.' . $allowedTypes[$imageType]);
                $success = 'Done';
                // Freeing memory , required only when handling multiple files for the sake of performance
                imagedestroy($image);
                imagedestroy($newImage);
            }
        }
    } else {
            // Show error message or handle error as how ever needed 
            $fileError = 'unsupported type of images';
    }
}


?>
<main>
    <form method="POST" enctype="multipart/form-data" class="file_form">
        <?php if(isset($fileError)): ?>
            <p class="danger" class="danger"><?= $fileError; ?></p>
        <?php endif;?>
        <?php if(isset($success)): ?>
            <p class="good"><?= $success; ?></p>
        <?php endif;?>
        <label for="image" id="image_label"> Drop an image</label>
        <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg" required>
        <input type="submit" value="Submit">
    </form>
</main>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins';
    }
    .danger{
        padding: .3rem 1rem;
        background-color: hsla(0, 100%, 50%, 0.2);
        color: red;
        border: 2px dashed red;
        border-radius: 10px;
    }
    .good{
        padding: .3rem 1rem;
        background-color: hsla(112, 100%, 50%, 0.2);
        color: hsla(112, 100%, 40%);
        border: 2px dashed hsla(112, 100%, 40%);
        border-radius: 10px;
    }

    main{
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .file_form{
        width: 100%;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    input[type=file] {
        display: none;
    }
    input[type=submit] {
        border-radius: 5px;
        outline: none;
        padding: .3rem 2rem;
        background-color: whitesmoke;
        border: 1px solid black;
        cursor: pointer;
    }

    .file_form > label{
        min-width: 150px;
        padding: 0 1rem;
        height: 70px;
        border: 2px black dotted;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 200ms ease-in-out;
    }
    .file_form > label:hover{
        border-color: red;
        cursor: pointer;
    }
</style>

<script defer>
    const input = document.getElementById('image')
    const label = document.getElementById('image_label')

    input.addEventListener('change', (e) => {
        label.innerText = e.target.files[0].name
        label.style.borderColor = 'red' 
        label.style.color = 'red'
    })
</script>
</body>
</html>