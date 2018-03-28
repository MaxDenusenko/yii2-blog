<?php

namespace app\controllers;

use app\models\Article;
use app\models\LikeArticle;
use app\models\search\ArticleFrontSearch;
use app\models\ViewsArticle;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii2mod\comments\controllers\ManageController;

class ArticleController extends Controller
{

    public $defaultPageSize = 4;

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleFrontSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $this->defaultPageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        ViewsArticle::check($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionLike($id)
    {
        LikeArticle::check($id);

        if (Yii::$app->request->isPjax) {

            $like = count(LikeArticle::getAll($id));
            $html = "<a href=\"/article/like?id=$id\" class=\"icon fa-heart\">$like</a>";
            return $html;
        }

        return $this->goBack();

    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article|\app\models\query\ArticleQuery
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::find()->active()->with('category')->with('tags')->with('user')->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
