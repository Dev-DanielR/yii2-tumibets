<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $is_admin
 * @property string $username
 * @property string $password
 * @property string $main_email
 * @property string|null $backup_email
 * @property string|null $cellphone
 * @property string $authKey
 * @property string $accessToken
 * @property string $is_validated
 * @property string $is_active
 * @property string $created
 *
 * @property Bet[] $bets
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'username', 'password', 'main_email', 'authKey', 'accessToken'], 'required'],
            [['id'], 'integer'],
            [['created'], 'safe'],
            [['is_admin', 'is_validated', 'is_active'], 'string', 'max' => 3],
            [['username', 'password', 'main_email', 'backup_email'], 'string', 'max' => 32],
            [['cellphone'], 'string', 'max' => 16],
            [['authKey', 'accessToken'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'is_admin'     => 'Is Admin',
            'username'     => 'Username',
            'password'     => 'Password',
            'main_email'   => 'Main Email',
            'backup_email' => 'Backup Email',
            'cellphone'    => 'Cellphone',
            'authKey'      => 'Auth Key',
            'accessToken'  => 'Access Token',
            'is_validated' => 'Is Validated',
            'is_active'    => 'Is Active',
            'created'      => 'Created',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * Gets query for [[Bets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBets()
    {
        return $this->hasMany(Bet::className(), ['user_id' => 'id']);
    }
}
