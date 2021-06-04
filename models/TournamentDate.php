<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_date".
 *
 * @property int $id
 * @property int $tournament_id
 * @property string|null $name
 * @property bool $is_active
 * @property int $user_created
 * @property string $time_created
 * @property int|null $user_updated
 * @property string|null $time_updated
 *
 * @property Fixture[] $fixtures
 * @property Tournament $tournament
 * @property User $userCreated
 * @property User $userUpdated
 */
class TournamentDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tournament_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id'], 'required'],
            [['tournament_id', 'user_created', 'user_updated'], 'integer'],
            [['is_active'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['tournament_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'tournament_id' => 'Tournament',
            'name'          => 'Name',
            'is_active'     => 'Is Active',
            'user_created'  => 'User Created',
            'time_created'  => 'Time Created',
            'user_updated'  => 'User Updated',
            'time_updated'  => 'Time Updated',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($insert) $this->user_created = Yii::$app->user->identity->id;
        else $this->user_updated = Yii::$app->user->identity->id;
        return true;
    }

    /**
     * Gets query for [[Fixtures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixtures()
    {
        return $this->hasMany(Fixture::className(), ['tournament_date_id' => 'id']);
    }

    /**
     * Gets query for [[Tournament]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }

    /**
     * Gets query for [[UserCreated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_created']);
    }

    /**
     * Gets query for [[UserUpdated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_updated']);
    }
}
