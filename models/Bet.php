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
 * @property string $created
 * @property string|null $updated
 *
 * @property Fixture $fixture
 * @property User $user
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
            [['id', 'fixture_id', 'user_id'], 'required'],
            [['id', 'fixture_id', 'user_id', 'teamA_score', 'teamB_score', 'bet_score'], 'integer'],
            [['is_active'], 'boolean'],
            [['created', 'updated'], 'safe'],
            [['id'], 'unique'],
            [['fixture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fixture::className(), 'targetAttribute' => ['fixture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'fixture_id'  => 'Fixture',
            'user_id'     => 'User',
            'teamA_score' => 'Team A Score',
            'teamB_score' => 'Team B Score',
            'bet_score'   => 'Bet Score',
            'is_active'   => 'Is Active',
            'created'     => 'Created',
            'updated'     => 'Updated',
        ];
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
}
