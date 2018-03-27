<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%views_article}}".
 *
 * @property int $id
 * @property string $created_at
 * @property int $article_id
 * @property string $ip
 * @property string $user_agent
 * @property int $user_id
 *
 * @property Article $article
 * @property User $user
 */
class ViewsArticle extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%views_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'ip'], 'required'],
            [['created_at'], 'safe'],
            [['article_id', 'user_id'], 'integer'],
            [['user_agent'], 'string'],
            [['ip'], 'string', 'max' => 20],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => date('Y-m-d H:i:s'),
            ]];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created'),
            'article_id' => Yii::t('app', 'Article'),
            'ip' => Yii::t('app', 'Ip'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }

    /**
     * Фиксирум просмотр документа
     * Не более 1 раза с одного IP в день
     * @param $article_id
     * @return bool
     */
    public static function check($article_id)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        // Проверяем наличие просмотров за сегодня с этого IP
        $model = ViewsArticle::find()->where('article_id=:article_id && ip=:ip && created_at>=:created_at', [
            ':article_id' => $article_id,
            ':ip' => $ip,
            ':created_at' => date('Y-m-d'). ' 00:00:00',
        ])->count();
        // Сохраняем запись
        if (!$model) {
            $visit = new ViewsArticle();
            $visit->article_id = $article_id;
            $visit->ip = $ip;
            $visit->user_id = (Yii::$app->user->isGuest) ? null : Yii::$app->user->id;
            $visit->user_agent = $_SERVER['HTTP_USER_AGENT'];
            $visit->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Получить просмотры документа/ов
     * при shedule = false - общее количество за все время
     * при shedule = true - количество просмотров, сгруппированные по дням
     * @param null $article_ids
     * @param bool $shedule
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll($article_ids = null, $shedule = false)
    {
        $table = self::tableName();
        $group_by = ($shedule) ? 'DATE(created_at)' : 'article_id';
        if ($article_ids) {
            $ids = (is_array($article_ids)) ? implode(',', $article_ids) : $article_ids;
            $sql = 'SELECT date(created_at) as created_at , article_id, count(article_id) as count FROM ' . $table . ' where article_id IN ('.$ids.') GROUP BY ' . $group_by;
        } else {
            $sql = 'SELECT date(created_at) as created_at , article_id, count(article_id) as count FROM ' . $table . ' GROUP BY ' . $group_by;
        }
        $model = ViewsArticle::findBySql($sql)->all();
        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\ViewsArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ViewsArticleQuery(get_called_class());
    }


}
