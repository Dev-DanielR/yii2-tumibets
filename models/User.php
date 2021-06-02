<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property bool $is_admin
 * @property string $username
 * @property string $password
 * @property string $main_email
 * @property string|null $backup_email
 * @property string|null $cellphone
 * @property string $authKey
 * @property string $accessToken
 * @property bool $is_validated
 * @property bool $is_active
 * @property string $created
 *
 * @property Bet[] $bets
 * @property Bet[] $betsCreated
 * @property Bet[] $betsUpdated
 * @property Fixture[] $fixturesCreated
 * @property Fixture[] $fixturesUpdated
 * @property Team[] $teamsCreated
 * @property Team[] $teamsUpdated
 * @property Tournament[] $tournamentsCreated
 * @property Tournament[] $tournamentsUpdated
 * @property TournamentDate[] $tournamentDatesCreated
 * @property TournamentDate[] $tournamentDatesUpdated
 * @property UserSession[] $userSessions
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['is_admin', 'is_validated', 'is_active'], 'boolean'],
            [['username', 'password', 'main_email', 'authKey', 'accessToken'], 'required'],
            [['created'], 'safe'],
            [['username', 'password', 'main_email', 'backup_email'], 'string', 'max' => 32],
            [['cellphone'], 'string', 'max' => 16],
            [['authKey', 'accessToken'], 'string', 'max' => 64],
            [['username'], 'unique'],
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
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($insert) {
            $this->authKey     = $this->generateString();
            $this->accessToken = $this->generateString();
        }
        return true;
    }

    /**
     * Generates strings for tokens.
     *
     * @return string generated string.
     */
    private function generateString()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($this->permitted_chars);
        $random_string = '';
        for($i = 0; $i < 64; $i++) {
            $random_character = $this->permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
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

    /**
     * Gets query for [[Bets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBetsCreated()
    {
        return $this->hasMany(Bet::className(), ['user_created' => 'id']);
    }

    /**
     * Gets query for [[Bets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBetsUpdated()
    {
        return $this->hasMany(Bet::className(), ['user_updated' => 'id']);
    }

    /**
     * Gets query for [[Fixtures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixturesCreated()
    {
        return $this->hasMany(Fixture::className(), ['user_created' => 'id']);
    }

    /**
     * Gets query for [[Fixtures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixturesUpdated()
    {
        return $this->hasMany(Fixture::className(), ['user_updated' => 'id']);
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsCreated()
    {
        return $this->hasMany(Team::className(), ['user_created' => 'id']);
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsUpdated()
    {
        return $this->hasMany(Team::className(), ['user_updated' => 'id']);
    }

    /**
     * Gets query for [[Tournaments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsCreated()
    {
        return $this->hasMany(Tournament::className(), ['user_created' => 'id']);
    }

    /**
     * Gets query for [[Tournaments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsUpdated()
    {
        return $this->hasMany(Tournament::className(), ['user_updated' => 'id']);
    }

    /**
     * Gets query for [[TournamentDates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentDatesCreated()
    {
        return $this->hasMany(TournamentDate::className(), ['user_created' => 'id']);
    }

    /**
     * Gets query for [[TournamentDates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentDatesUpdated()
    {
        return $this->hasMany(TournamentDate::className(), ['user_updated' => 'id']);
    }

    /**
     * Gets query for [[UserSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSessions()
    {
        return $this->hasMany(UserSession::className(), ['user_id' => 'id']);
    }
}
