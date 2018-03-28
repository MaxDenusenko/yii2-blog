<?php

namespace app\modules\admin\controllers;

use app\models\AuthItem;
use Yii;
use app\models\AuthItemChild;
use app\models\search\AuthItemChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemChildController implements the CRUD actions for AuthItemChild model.
 */
class AuthItemChildController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItemChild models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemChildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new AuthItemChild();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $child = AuthItemChild::find()->where(['parent' => $model->parent])->andWhere(['child' => $model->child])->count();
            if (!$child) {

                $parent = AuthItem::find()->where(['name' => $model->parent])->one();
                $child = AuthItem::find()->where(['name' => $model->child])->one();

                if ($parent->type == 1)
                    $parent = Yii::$app->authManager->getRole($model->parent);
                elseif ($parent->type == 2)
                    $parent = Yii::$app->authManager->getPermission($model->parent);

                if ($child->type == 1)
                    $child = Yii::$app->authManager->getRole($model->child);
                elseif ($child->type == 2)
                    $child = Yii::$app->authManager->getPermission($model->child);

                Yii::$app->authManager->addChild($parent, $child);

                return $this->redirect(['index']);
            }

            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Inheritance already exist'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $parent
     * @param $child
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($parent, $child)
    {
        $this->findModel($parent, $child)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $parent
     * @param string $child
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
