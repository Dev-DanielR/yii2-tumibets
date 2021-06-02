<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bet".
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $user_id
 * @property int|null $teamA_score
 * @property int|null $teamB_score
 * @property int|null $bet_score
 * @property bool $is_active
 * @property int $user_created
 * @property string $time_created
 * @property int|null $user_updated
 * @property string|null $time_updated
 *
 * @property Fixture $fixture
 * @property User $user
 * @property User $userCreated
 * @property User $userUpdated
 */
class Bet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fixture_id', 'user_id', 'user_created', 'teamA_score', 'teamB_score'], 'required'],
            [['fixture_id', 'user_id', 'teamA_score', 'teamB_score', 'bet_score', 'user_created', 'user_updated'], 'integer'],
            [['is_active'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
            [['fixture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fixture::className(), 'targetAttribute' => ['fixture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'id'           => 'ID',
            'fixture_id'   => 'Fixture ID',
            'user_id'      => 'User ID',
            'teamA_score'  => 'Team A Score',
            'teamB_score'  => 'Team B Score',
            'bet_score'    => 'Bet Score',
            'is_active'    => 'Is Active',
            'user_created' => 'User Created',
            'time_created' => 'Time Created',
            'user_updated' => 'User Updated',
            'time_updated' => 'Time Updated',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($insert) {
            $this->user_created = Yii::$app->user->identity->id;
            $this->time_created = date('Y-m-d H:i:s');
        } else {
            $this->user_updated = Yii::$app->user->identity->id;
            $this->time_updated = date('Y-m-d H:i:s');
        }
        return true;
    }

    /**
     * Gets query for [[Fixture]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixture()
    {
        return $this->hasOne(Fixture::className(), ['id' => 'fixture_id']);
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
