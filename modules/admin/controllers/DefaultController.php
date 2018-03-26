<?php

namespace app\modules\admin\controllers;

use yii\base\DynamicModel;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;
use Exception;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $dir
     * @param $image
     * @return bool|string
     */
    public static function loadFile($dir, $image)
    {
        $fileName = DefaultController::generateRandomName().'.'.$image->extension;

        try {
            $image->saveAs($dir.$fileName);
        } catch (\Exception $exception) {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Could not save image ').$image->name);
            return false;
        }

        return $fileName;
    }

    /**
     * @return bool
     */
    public static function generateRandomName()
    {
        try {
            $string = strtotime('now') . '_' . \Yii::$app->getSecurity()->generateRandomString(6);
        } catch (\Exception $e) {
            return false;
        }

        return $string;
    }

    /**
     * @param $pathToFile
     * @return bool
     */
    public static function removeFile($pathToFile)
    {
        if (is_file($pathToFile) && file_exists($pathToFile))
            unlink($pathToFile);

        return true;
    }

    /**
     * @param $path
     * @return bool
     */
    public static function createDir($path)
    {
        if (!file_exists($path)) {
            try {
                FileHelper::createDirectory($path);
            } catch (\Exception $exception) {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Could not create directory ').$path);
                return false;
            }
        }
        return true;
    }

    /**
     * Saving editor files to a $sub directory
     * @param string $sub
     * @return array|\Exception|Exception
     * @throws BadRequestHttpException
     */
    public function actionSaveRedactorFile($sub='main')
    {
        $this->enableCsrfValidation = false;

        if (\Yii::$app->request->isPost) {


            $result_link = '/resources/file/'.$sub.'/';
            $dir = \Yii::getAlias('@webroot').$result_link;

            if (!DefaultController::createDir($dir))
                throw new BadRequestHttpException();

            $file = UploadedFile::getInstanceByName('file');

            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'file')->validate();

            if ($model->hasErrors()) {

                $result = ['error' => $model->getFirstError('file')];
            } else {

                if ($model->file->name = DefaultController::loadFile($dir, $model->file)) {

                    $result = ['filelink' => $result_link.$model->file->name, 'filename' => $model->file->name];
                } else {

                    $result = ['error' => \Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')];
                }
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException('Only POST as allowed');
        }
    }

    /**
     * Saving images of the editor to the directory $sub
     * @param string $sub
     * @return array|\Exception|Exception
     * @throws BadRequestHttpException
     */
    public function actionSaveRedactorImg($sub='main')
    {
        $this->enableCsrfValidation = false;

        if (\Yii::$app->request->isPost) {

            $result_link = '/resources/img/'.$sub.'/';
            $dir = \Yii::getAlias('@webroot').$result_link;

            if (!DefaultController::createDir($dir))
                throw new BadRequestHttpException();

            $file = UploadedFile::getInstanceByName('file');

            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image', ['extensions' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2])->validate();

            if ($model->hasErrors()) {

                $result = ['error' => $model->getFirstError('file')];
            } else {

                if ($model->file->name = DefaultController::loadFile($dir, $model->file)) {

                    DefaultController::compress_image($dir.$model->file->name, $dir.$model->file->name, 65);
                    $result = ['filelink' => $result_link.$model->file->name, 'filename' => $model->file->name];
                } else {

                    $result = ['error' => \Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')];
                }
            }
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException(\Yii::t('app', 'Only POST as allowed'));
        }
    }

    /**
     * @param $source_url
     * @param $destination_url
     * @param $quality
     * @return mixed
     */
    public static function compress_image($source_url, $destination_url, $quality) {

       $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
              $image = imagecreatefromjpeg($source_url);

        elseif ($info['mime'] == 'image/gif')
              $image = imagecreatefromgif($source_url);

        elseif ($info['mime'] == 'image/png')
              $image = imagecreatefrompng($source_url);

        imagejpeg($image, $destination_url, $quality);

        return $destination_url;
    }
}
