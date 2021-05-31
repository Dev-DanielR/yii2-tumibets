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
            [['tournament_date_id', 'teamA_id', 'teamB_id'], 'required'],
            [['tournament_date_id', 'teamA_id', 'teamB_id', 'teamA_score', 'teamB_score'], 'integer'],
            [['start', 'end'], 'safe'],
            [['is_active'], 'boolean'],
            [['teamA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamA_id' => 'id']],
            [['teamB_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['teamB_id' => 'id']],
            [['tournament_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => TournamentDate::className(), 'targetAttribute' => ['tournament_date_id' => 'id']],
            [['teamB_id'], 'differentTeams'],
            [['end'], 'endLater']
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;

        $this->start = date("Y-m-d H:i:s", strtotime(str_replace('/', '.', $this->start)));
        $this->end   = date("Y-m-d H:i:s", strtotime(str_replace('/', '.', $this->end)));

        return true;
    }

    /**
     * Check if teamB is different from teamA.
     */
    public function differentTeams(){
        if (!empty($this->teamA_id) && !empty($this->teamB_id)) {
            if ($this->teamA_id == $this->teamB_id) $this->addError('teamB_id', 'Teams must be different.');
        }
    }

    /**
     * Check if end is at a later time than start.
     */
    public function endLater(){
        if (!empty($this->start) && !empty($this->end)) {
            $start_unix = strtotime(str_replace('/', '.', $this->start));
            $end_unix   = strtotime(str_replace('/', '.', $this->end));
            if ($start_unix >= $end_unix) $this->addError('end', 'Fixture cannot end before starting.');
        }
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
