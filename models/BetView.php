<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bet_view".
 *
 * @property int         $id
 * @property string|null $tournament
 * @property string|null $tournament_date
 * @property string|null $fixture
 * @property string|null $user
 * @property string|null $teamA
 * @property int|null    $teamA_score
 * @property int|null    $teamA_predicted_score
 * @property string|null $teamB
 * @property int|null    $teamB_score
 * @property int|null    $teamB_predicted_score
 * @property int|null    $bet_score
 * @property bool        $is_active
 * @property string|null $user_created
 * @property string      $time_created
 * @property string|null $user_updated
 * @property string|null $time_updated
 */
class BetView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bet_view';
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'teamA_score', 'teamA_predicted_score', 'teamB_score', 'teamB_predicted_score', 'bet_score'], 'integer'],
            [['is_active'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
            [['tournament', 'teamA', 'teamB'], 'string', 'max' => 64],
            [['tournament_date'], 'string', 'max' => 45],
            [['fixture'], 'string', 'max' => 132],
            [['user', 'user_created', 'user_updated'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'tournament'            => Yii::t('app', 'Tournament'),
            'tournament_date'       => Yii::t('app', 'Tournament Date'),
            'fixture'               => Yii::t('app', 'Fixture'),
            'user'                  => Yii::t('app', 'User'),
            'teamA'                 => Yii::t('app', 'Team A'),
            'teamA_score'           => Yii::t('app', 'Team A Score'),
            'teamA_predicted_score' => Yii::t('app', 'Team A Predicted Score'),
            'teamB'                 => Yii::t('app', 'Team B'),
            'teamB_score'           => Yii::t('app', 'Team B Score'),
            'teamB_predicted_score' => Yii::t('app', 'Team B Predicted Score'),
            'bet_score'             => Yii::t('app', 'Bet Score'),
            'is_active'             => Yii::t('app', 'Is Active'),
            'user_created'          => Yii::t('app', 'User Created'),
            'time_created'          => Yii::t('app', 'Time Created'),
            'user_updated'          => Yii::t('app', 'User Updated'),
            'time_updated'          => Yii::t('app', 'Time Updated'),
        ];
    }
}
