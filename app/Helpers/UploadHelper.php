<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UploadHelper
{
    private static $disk = 'local';
    private static $path;
    private static $newPath = '';
    private static $name;
    private static $file;
    private static $extension;
    private static $informations;
    private static $availableExtensions = ['png', 'jpg', 'jpeg', 'mp4', 'swf'];
    private static $currentDate;
    private static $instance;
    private static $isReload = false;

    public static function setAvailableExtensions(array $extensions)
    {
        self::$availableExtensions = $extensions;
        return self::getInstance();
    }

    public static function addText(array $options)
    {
        $targetFilePath = Storage::disk(self::$disk)->path(self::$newPath);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

        if (in_array($fileType, ['jpg', 'jpeg'])) {
            $image = imagecreatefromjpeg($targetFilePath);
        } else {
            $image = imagecreatefrompng($targetFilePath);
        }

        $color = imagecolorallocate($image, 255, 255, 0);
        
        imagestring($image, $options['font_size'], $options['x'], $options['y'], $options['text'], $color);
        
        if (in_array($fileType, ['jpg', 'jpeg'])) {
            imagejpeg($image, $targetFilePath);
        } else {
            imagepng($image, $targetFilePath);
        }

        return self::getInstance();
    }
    
    public static function addWatermark($watermarkPath, array $options)
    {
        $targetFilePath = Storage::disk(self::$disk)->path(self::$newPath);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

        $watermark = imagecreatefrompng(public_path($watermarkPath));

        if (in_array($fileType, ['jpg', 'jpeg'])) {
            $im = imagecreatefromjpeg($targetFilePath);
        } else {
            $im = imagecreatefrompng($targetFilePath);
        }

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = $options['marge_right'];
        $marge_bottom = $options['marge_bottom'];
        $sx = imagesx($watermark);
        $sy = imagesy($watermark);

        // Copy the stamp image onto our photo using the margin offsets and the photo 
        // width to calculate positioning of the stamp. 
        imagecopy($im, $watermark, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermark), imagesy($watermark));
         
        if (in_array($fileType, ['jpg', 'jpeg'])) {
            imagejpeg($im, $targetFilePath); 
        } else {
            imagepng($im, $targetFilePath); 
        }

        imagedestroy($im); 

        return self::getInstance();
    }

    public static function setExternalUrl($url)
    {
        $info = pathinfo(preg_replace('/\?.*/', '', $url));
         
        $contents = file_get_contents($url);
        $extension = explode(':', $info['extension']);
        self::$newPath = self::$path . '/' . $info['filename'] . '.' . $extension[0];

        Storage::disk(self::$disk)->put(self::$newPath, $contents);

        return self::$instance;
    }

    private static function getInstance(): UploadHelper
    {
        if (empty(self::$instance)) {
            self::setInstance();
        }

        return self::$instance;
    }

    public static function getExtension()
    {
        return self::$extension;
    }

    public static function render()
    {
        $filepath = Storage::disk(self::$disk)->path(self::$path);

        if (!File::exists($filepath)) {
            abort(404);
        }

        $file = File::get($filepath);
        $type = File::mimeType($filepath);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public static function getFullPath(): string
    {
        return self::$newPath;
    }

    public static function getInfoFile($param = false): array
    {
        $info = pathinfo(self::$newPath);
        $info['fullpath'] = self::getPath();

        if (empty(self::$path) == false) {

            if (empty(self::$isReload) == false) {
                $info['basename'] = self::$path;
            } else {
                $info['basename'] = self::$path . '/' . $info['basename'];
            }

            if ($param == 'with-url') {
                $info['url'] = url('storage/' . $info['basename']);
            }
        }

        return $info;
    }

    public static function getInformation()
    {
        return pathinfo(self::$path);
    }

    public static function getName()
    {
        $fileNames = explode('.', self::$name);

        $fileNames[0] = $fileNames[0]. '-' .self::$currentDate;

        return implode('.', $fileNames);
    }

    public static function copyTo($newPath)
    {
        $fileInfo = self::getInformation();

        if (!Storage::disk(self::$disk)->exists($newPath . '/' . $fileInfo['basename'])) {
            Storage::disk(self::$disk)->copy(self::$path, $newPath . '/' . $fileInfo['basename']);
        }

        return $newPath . '/' . $fileInfo['basename'];
    }

    private static function setInstance()
    {
        self::$instance = new static();
    }

    public static function setDisk($disk)
    {
        self::$disk = $disk;
        return self::getInstance();
    }

    public static function setPath($path, $isReload = false)
    {
        self::$isReload = $isReload;
        self::$path = $path;
        return self::getInstance();
    }

    public static function setNewPath($path)
    {
        self::$newPath = $path;
        return self::getInstance();
    }

    public static function getPath()
    {
        return Storage::disk(self::$disk)->path(self::$path);
    }

    public static function fileExists($path = null)
    {
        $path = $path ?? self::getPath();
        return Storage::disk(self::$disk)->exists($path);
    }

    public static function setFile($file)
    {
        self::$file = $file;
        self::$name = $file->getClientOriginalName();
        self::$extension = $file->getClientOriginalExtension();
        self::$currentDate = date('Y-m-d-H-i');

        return self::getInstance();
    }

    public static function save()
    {
        if (in_array(strtolower(self::$file->getClientOriginalExtension()), self::$availableExtensions)) {
            self::insertFile();
        } else {
            throw new \Exception('Extensão do arquivo não é valida.');
        }

        return self::$instance;
    }

    public static function saveBinary(string $filename, $binary)
    {
        Storage::disk(self::$disk)->put(self::$path . '/' . $filename, $binary);

        self::$newPath = self::$path . '/' . $filename;
        
        self::$informations = self::getInfoFile();

        return self::getInstance();
    }

    public static function remove($path = null)
    {
        Storage::disk(self::$disk)->delete($path ?? self::$path);
    }

    private static function insertFile()
    {
        
        self::$newPath = self::$file->storeAs(self::$path, md5_file(self::$file) . '.' . strtolower(self::$file->getClientOriginalExtension()), self::$disk);

        self::$informations = self::getInfoFile();

        return self::getInstance();
    }

    public static function getFiles($directory)
    {
        return Storage::disk(self::$disk)->allFiles($directory);
    }

    public static function getDirectoryPath($directory)
    {
        return Storage::disk(self::$disk)->path($directory);
    }

    public static function makeDirectory($directory)
    {
        Storage::disk(self::$disk)->makeDirectory($directory);
    }

    public static function convertExtension(array $extensionsToConvert = [], $extensionTo = null)
    {

        if (empty($extensionsToConvert) || empty($extensionTo)) {
            return self::$instance;
        }

        if (!in_array(self::$file->getClientOriginalExtension(), $extensionsToConvert)) {
            return self::$instance;
        }

        $fileInserted = self::$informations;
        $fullpath = $fileInserted['fullpath'] . '/' . $fileInserted['filename'] . '.' . $fileInserted['extension'];

        $image = new \imagick($fullpath);
        $image->setImageFormat($extensionTo);
        $image->writeImage($fileInserted['fullpath'] . '/' . $fileInserted['filename'] . "." . $extensionTo);
        $image->clear();
        $image->destroy(); 
        
        self::$newPath = $fileInserted['fullpath'] . '/' . $fileInserted['filename'] . "." . $extensionTo;

        self::remove($fileInserted['basename']);

        return self::$instance;
    }

    public static function resize($maxWidth = 1920, $maxHeight = 1920)
    {
        $fileInserted = self::getInfoFile();

        if (!in_array($fileInserted['extension'], ['jpg', 'jpeg', 'png'])) {
            return self::$instance;
        }

        $fullpath = $fileInserted['fullpath'] . '/' . $fileInserted['filename'] . '.' . $fileInserted['extension'];
       
        $fileType = pathinfo($fullpath, PATHINFO_EXTENSION);
        $size = @getimagesize($fullpath);
        $ratio = $size[0] / $size[1]; // width/height

        if( $maxWidth > $size[0] && $maxHeight > $size[1]) {
            return;
        }
        if( $ratio > 1) {
            $width = $maxWidth;
            $height = $maxHeight / $ratio;
        } else {
            $width = $maxWidth * $ratio;
            $height = $maxHeight;
        }

        $src = imagecreatefromstring(file_get_contents($fullpath));
        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagedestroy($src);

        if (in_array($fileType, ['jpg', 'jpeg']) == true) {
            imagejpeg($dst, $fullpath);
        } else {
            imagepng($dst, $fullpath);
        }

        imagedestroy($dst);

        return self::$instance;
    }

    public static function cutVideo($folderToSave, $startSecond = false, $endSecond = false)
    {
        if (empty($startSecond) && empty($endSecod) ) {
            return;
        }

        $fileInserted = self::getInfoFile();
        $newPath = $folderToSave . '/' . $fileInserted['filename'] . '.' . $fileInserted['extension'];

        if (!in_array($fileInserted['extension'], ['mp4', 'flv']) || $endSecond === 0 || Storage::disk(self::$disk)->exists($newPath)) {
            return self::$instance;
        }
        
        $fullpath = $fileInserted['fullpath'] . '/' . $fileInserted['filename'] . '.' . $fileInserted['extension'];
        $removeAudioFilter = '-an';
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $video = $ffmpeg->open($fullpath);
        $video = $video->addFilter(new \FFMpeg\Filters\Audio\SimpleFilter([$removeAudioFilter]));
        $video = $video->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($startSecond), \FFMpeg\Coordinate\TimeCode::fromSeconds($endSecond));

        self::makeDirectory($folderToSave);

        self::$newPath = storage_path('app/public') . '/' . $newPath;
        self::$path = $folderToSave;

        $video->save(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'), self::$newPath);
        
        return self::$instance;
    }
}
