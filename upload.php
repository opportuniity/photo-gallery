<?php
const UPLOAD_ERROR_MESSAGES = [
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
];
const PHOTO_MAX_SIZE = 2 * 1024 * 1024; //2Mb
const PHOTO_AVAILABLE_TYPES = [
    'image/jpeg',
    'image/png',
];
const PHOTO_DIR = 'images';

$errors = [];
if(empty($_FILES['photo'])){
    $errors[] = 'No POST data for file';
} else{
    $photoFile = $_FILES['photo'];
    if($photoFile['error'] !== UPLOAD_ERR_OK){
        $errors[] = UPLOAD_ERROR_MESSAGES[$photoFile['error']];
    }else{
        if(!in_array($photoFile['type'], PHOTO_AVAILABLE_TYPES)){
            $errors[] = 'Not available type';
        }
        if($photoFile['size'] > PHOTO_MAX_SIZE){
            $errors[] = 'Photo is too large';
        }
        if(count($errors) == 0){
            $extension = pathinfo($photoFile['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '.' . $extension;
            $fileName = PHOTO_DIR . DIRECTORY_SEPARATOR . $uniqueName;
            if(!move_uploaded_file($photoFile['tmp_name'], $fileName)){
                $errors[] = 'Photo was not uploaded';            }
        }    }
}
header('Location: index.php' . (count($errors) > 0 ? '?errors=' . urlencode(implode(',', $errors)) : ''));
exit();
