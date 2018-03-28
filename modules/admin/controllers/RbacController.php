<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;


/**
 * Rbac.
 */
class RbacController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}