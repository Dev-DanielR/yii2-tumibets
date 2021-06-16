<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixture".
 *
 * @property int         $id
 * @property int         $tournament_date_id
 * @property int         $teamA_id
 * @property int         $teamB_id
 * @property int         $teamA_score
 * @property int         $teamB_score
 * @property string|null $start
 * @property string|null $end
 * @property bool        $is_active
 * @property int         $user_created
 * @property string      $time_created
 * @property int|null    $user_updated
 * @property string|null $time_updated
 *
 * @property Bet[]          $bets
 * @property Team           $teamA
 * @property Team           $teamB
 * @property TournamentDate $tournamentDate
 * @property User           $userCreated
 * @property User           $userUpdated
 */
class Fixture extends \yii\db\ActiveRecord
{
    protected $DB_format = 'Y-m-d H:i:s';
    protected $read_format = 'd/m/y h:i A';

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
            'id'                 => Yii::t('app', 'ID'),
            'tournament_date_id' => Yii::t('app', 'Tournament Date'),
            'teamA_id'           => Yii::t('app', 'Team A'),
            'teamB_id'           => Yii::t('app', 'Team B'),
            'teamA_score'        => Yii::t('app', 'Team A Score'),
            'teamB_score'        => Yii::t('app', 'Team B Score'),
            'start'              => Yii::t('app', 'Start Time'),
            'end'                => Yii::t('app', 'End Time'),
            'is_active'          => Yii::t('app', 'Is Active'),
            'user_created'       => Yii::t('app', 'User Created'),
            'time_created'       => Yii::t('app', 'Time Created'),
            'user_updated'       => Yii::t('app', 'User Updated'),
            'time_updated'       => Yii::t('app', 'Time Updated'),
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
        $this->datesToDBFormat();
        return true;
    }

    /**
     * Converts dates to db format.
     */
    protected function datesToDBFormat()
    {
        $this->start = date($this->DB_format,
            date_create_from_format($this->read_format, $this->start)->getTimestamp()
        );
        $this->end = date($this->DB_format,
            date_create_from_format($this->read_format, $this->end)->getTimestamp()
        );
    }

    /**
     * Converts dates to read format.
     */
    public function datesToReadFormat()
    {
        $this->start = date($this->read_format,
            date_create_from_format($this->DB_format, $this->start)->getTimestamp()
        );
        $this->end = date($this->read_format,
            date_create_from_format($this->DB_format, $this->end)->getTimestamp()
        );
    }

    /**
     * Gets name
     */
    public function getName()
    {
        return $this->teamA->name . ' vs ' . $this->teamB->name;
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
