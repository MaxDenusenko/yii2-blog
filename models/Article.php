<?php

namespace app\models;

use app\modules\admin\controllers\DefaultController;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $publisher_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property Category $category
 * @property User $user
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $tags_array;

    const STATUS_POSTED = 1;
    const STATUS_WAIT = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'image', 'extensions' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2],
            [['title', 'description', 'content', 'status', 'category_id'], 'required'],
            [['created_at', 'updated_at', 'publisher_at', 'tags_array'], 'safe'],
            [['description', 'content'], 'string'],
            [['viewed', 'user_id', 'status', 'category_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'updated_at' => Yii::t('app', 'Updated At'),
            'publisher_at' => Yii::t('app', 'Publisher At'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'image' => Yii::t('app', 'Image'),
            'viewed' => Yii::t('app', 'Viewed'),
            'user_id' => Yii::t('app', 'User'),
            'status' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category'),
            'tags_array' => Yii::t('app', 'Tags'),
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        return parent::beforeValidate();
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->image) {

            $file = Yii::getAlias('@webroot').'/resources/img/article/'.$this->image;
            DefaultController::removeFile($file);
        }

        return parent::beforeDelete();
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
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d'),
            ]];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $imageDir = Yii::getAlias('@webroot').'/resources/img/article/';

        if (!DefaultController::createDir($imageDir))
            return false;

        $pathToFile = $imageDir.$this->image;

        if (isset($this->imageFile) && !$this->imageFile->error && $this->image && file_exists($pathToFile))
            DefaultController::removeFile($pathToFile);

        if (isset($this->imageFile)) {

            if (!$this->imageFile->error){

                if (!$imageName = DefaultController::loadFile($imageDir, $this->imageFile))
                    return false;
                else {
                    $this->image = $imageName;
                    DefaultController::compress_image($imageDir.$imageName, $imageDir.$imageName, 65);
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Could not save image '));
                return false;
            }
        }
        $this->dateSetting();

        if (!$this->user_id)
            $this->user_id = \Yii::$app->user->identity->id;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->tags_array = $this->tags;

        parent::afterFind();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $tags = ArrayHelper::map($this->getTags()->all(),'id', 'id');
        $newTags = $this->tags_array;

        foreach ($newTags as $tag) {
            if (!in_array($tag, $tags)) {

                $model = new ArticleTag();
                $model->article_id = $this->id;
                $model->tag_id = $tag;
                $model->save();
            }

            if (isset($tags[$tag]))
                unset($tags[$tag]);
        }

        ArticleTag::deleteAll(['tag_id' => $tags]);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Get full image for front
     * end
     * @return string
     */
    public function getFullImage()
    {
        $dir = str_replace('admin', '', Url::home(true)).'/resources/img/article/';
        return $dir.$this->image;
    }

    /**
     * @return bool
     */
    public function dateSetting()
    {
        if (!$this->publisher_at && $this->status != 0)
            $this->publisher_at = date('Y-m-d');

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViewsArticles()
    {
        return $this->hasMany(ViewsArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikeArticles()
    {
        return $this->hasMany(LikeArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('articleTags');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArticleQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_POSTED => Yii::t('app', 'Posted'),
            self::STATUS_WAIT => Yii::t('app', 'Wait'),
        ];
    }
}
