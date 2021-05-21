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
 * @property string $start
 * @property string|null $end
 * @property bool $is_active
 *
 * @property Bet[] $bets
 * @property Team $teamA
 * @property Team $teamB
 * @property TournamentDate $tournamentDate
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
            [['id', 'tournament_date_id', 'teamA_id', 'teamB_id'], 'required'],
            [['id', 'tournament_date_id', 'teamA_id', 'teamB_id', 'teamA_score', 'teamB_score'], 'integer'],
            [['start', 'end'], 'safe'],
            [['is_active'], 'boolean'],
            [['id'], 'unique'],
            [['teamA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamA_id' => 'id']],
            [['teamB_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamB_id' => 'id']],
            [['tournament_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentDate::className(), 'targetAttribute' => ['tournament_date_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'tournament_date_id' => 'Tournament Date ID',
            'teamA_id'           => 'Team A ID',
            'teamB_id'           => 'Team B ID',
            'teamA_score'        => 'Team A Score',
            'teamB_score'        => 'Team B Score',
            'start'              => 'Start',
            'end'                => 'End',
            'is_active'          => 'Is Active',
        ];
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
}