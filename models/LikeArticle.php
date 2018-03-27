<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "{{%like_article}}".
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
class LikeArticle extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%like_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'ip'], 'required'],
            [['created_at'], 'safe'],
            [['article_id', 'user_id', 'count'], 'integer'],
            [['user_agent'], 'string'],
            [['ip'], 'string', 'max' => 20],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'article_id' => Yii::t('app', 'Article ID'),
            'ip' => Yii::t('app', 'Ip'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

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
     * @return \app\models\query\LikeArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\LikeArticleQuery(get_called_class());
    }

    /**
     * Фиксируем Лайк
     * Не более 1 лайка с одного IP
     * @param $article_id
     * @return bool
     */
    public static function check($article_id)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        // Проверяем наличие лайка с этого IP
        $model = LikeArticle::find()->where('article_id=:article_id && ip=:ip', [
            ':article_id' => $article_id,
            ':ip' => $ip
        ])->one();
        // Сохраняем запись
        if (!$model) {
            $visit = new LikeArticle();
            $visit->article_id = $article_id;
            $visit->ip = $ip;
            $visit->user_id = (Yii::$app->user->isGuest) ? null : Yii::$app->user->id;
            $visit->user_agent = $_SERVER['HTTP_USER_AGENT'];
            $visit->save();
            return true;
        } else {
            try {
                $model->delete();
            } catch (StaleObjectException $e) {
            } catch (\Exception $e) {}
            return false;
        }
    }
    /**
     * Получить Лайки документа/ов
     * при shedule = flase - общее количество за все время
     * при shedule = true - количество лайков, сгруппированные по дням
     * @param null $article_ids - ID документа (-ов)
     * @param bool $shedule - включить расписание просмотров?
     * @return array|\yii\db\ActiveRecord[] - возвращает только дату, id документа, кол-во лайков
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
        $model = LikeArticle::findBySql($sql)->all();
        return $model;
    }
}
