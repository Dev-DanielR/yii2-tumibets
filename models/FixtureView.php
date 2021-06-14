<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixture_view".
 *
 * @property int         $id
 * @property string|null $tournament
 * @property string|null $tournament_date
 * @property string|null $name
 * @property string|null $teamA
 * @property int         $teamA_score
 * @property string|null $teamB
 * @property int         $teamB_score
 * @property bool        $is_active
 * @property string|null $start
 * @property string|null $end
 * @property string|null $user_created
 * @property string      $time_created
 * @property string|null $user_updated
 * @property string|null $time_updated
 */
class FixtureView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fixture_view';
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
            [['id', 'teamA_score', 'teamB_score'], 'integer'],
            [['is_active'], 'boolean'],
            [['start', 'end', 'time_created', 'time_updated'], 'safe'],
            [['tournament', 'teamA', 'teamB'], 'string', 'max' => 64],
            [['tournament_date'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 132],
            [['user_created', 'user_updated'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'tournament'      => Yii::t('app', 'Tournament'),
            'tournament_date' => Yii::t('app', 'Tournament Date'),
            'name'            => Yii::t('app', 'Name'),
            'teamA'           => Yii::t('app', 'Team A'),
            'teamA_score'     => Yii::t('app', 'Team A Score'),
            'teamB'           => Yii::t('app', 'Team B'),
            'teamB_score'     => Yii::t('app', 'Team B Score'),
            'is_active'       => Yii::t('app', 'Is Active'),
            'start'           => Yii::t('app', 'Start'),
            'end'             => Yii::t('app', 'End'),
            'user_created'    => Yii::t('app', 'User Created'),
            'time_created'    => Yii::t('app', 'Time Created'),
            'user_updated'    => Yii::t('app', 'User Updated'),
            'time_updated'    => Yii::t('app', 'Time Updated'),
        ];
    }
}
