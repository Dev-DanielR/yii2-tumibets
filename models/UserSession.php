<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_session".
 *
 * @property int $id
 * @property int $user_id
 * @property string $login_timestamp
 * @property string|null $logout_timestamp
 *
 * @property User $user
 */

class UserSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['login_timestamp', 'logout_timestamp'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'user_id'          => Yii::t('app', 'User'),
            'login_timestamp'  => Yii::t('app', 'Login Timestamp'),
            'logout_timestamp' => Yii::t('app', 'Logout Timestamp'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
