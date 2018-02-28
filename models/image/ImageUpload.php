<?php

namespace app\models\image;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            //[['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png'],
        ];
    }

    public function uploadFile(UploadedFile $file = null, $currentImage = null)
    {
        $this->image = $file;

        if ($this->image && $this->validate()){
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
        return $currentImage;
    }

    public function getFolder()
    {
        return Yii::getAlias('@web'). 'uploads/';
    }

    public function generateFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)) .'.'. $this->image->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage)){
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if (!empty($currentImage) && $currentImage != null){
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage()
    {
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }


}