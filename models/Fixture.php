<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixture".
 *
 * @property int $id
 * @property int $tournament_date_id
 * @property int $teamA_id
 * @property int $teamB_id
 * @property int $teamA_score
 * @property int $teamB_score
 * @property string|null $start
 * @property string|null $end
 * @property bool $is_active
 * @property int $user_created
 * @property string $time_created
 * @property int|null $user_updated
 * @property string|null $time_updated
 *
 * @property Bet[] $bets
 * @property Team $teamA
 * @property Team $teamB
 * @property TournamentDate $tournamentDate
 * @property User $userCreated
 * @property User $userUpdated
 */
class Fixture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fixture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_date_id', 'teamA_id', 'teamB_id', 'user_created'], 'required'],
            [['tournament_date_id', 'teamA_id', 'teamB_id', 'teamA_score', 'teamB_score', 'user_created', 'user_updated'], 'integer'],
            [['start', 'end', 'time_created', 'time_updated'], 'safe'],
            [['is_active'], 'boolean'],
            [['teamA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamA_id' => 'id']],
            [['teamB_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamB_id' => 'id']],
            [['tournament_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentDate::className(), 'targetAttribute' => ['tournament_date_id' => 'id']],
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
            'id'                 => 'ID',
            'tournament_date_id' => 'Tournament Date',
            'teamA_id'           => 'Team A',
            'teamB_id'           => 'Team B',
            'teamA_score'        => 'Team A Score',
            'teamB_score'        => 'Team B Score',
            'start'              => 'Start',
            'end'                => 'End',
            'is_active'          => 'Is Active',
            'user_created'       => 'User Created',
            'time_created'       => 'Time Created',
            'user_updated'       => 'User Updated',
            'time_updated'       => 'Time Updated',
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
     * Gets query for [[Bets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBets()
    {
        return $this->hasMany(Bet::className(), ['fixture_id' => 'id']);
    }

    /**
     * Gets query for [[TeamA]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamA()
    {
        return $this->hasOne(Team::className(), ['id' => 'teamA_id']);
    }

    /**
     * Gets query for [[TeamB]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamB()
    {
        return $this->hasOne(Team::className(), ['id' => 'teamB_id']);
    }

    /**
     * Gets query for [[TournamentDate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentDate()
    {
        return $this->hasOne(TournamentDate::className(), ['id' => 'tournament_date_id']);
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
