<?php

namespace app\models\form;

use app\models\User;
use codemix\yii2confload\Config;
use yii\base\Model;
use Yii;

/**
* Signup form
*/
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rpPassword;
    public $verifyCode;
    public $reCaptcha;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::className()],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className()],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['rpPassword', 'required'],
            ['rpPassword', 'string', 'min' => 6],
            ['rpPassword', 'compare', 'compareAttribute' => 'password'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => Yii::t('app', 'Please confirm that you are not a bot.')]
//            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Name'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'rpPassword' => Yii::t('app', 'Confirm password'),
            'verifyCode' => Yii::t('app', 'Verify code'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save()) {

                $sendGrid = \Yii::$app->sendGrid;
                $message = $sendGrid->compose('emailConfirm', ['user' => $user]);
                $message->setFrom([Yii::$app->params['adminEmail'] => \Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject(Yii::t('app', 'Email Confirmation for'). ' ' . Yii::$app->name)
                    ->send($sendGrid);
                    return $user;
                }
            }

        return null;
    }
}
