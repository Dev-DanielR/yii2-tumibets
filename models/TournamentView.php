<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_view".
 *
 * @property int         $id
 * @property string      $name
 * @property bool        $is_active
 * @property int|null    $tournament_date_count
 * @property string|null $user_created
 * @property string      $time_created
 * @property string|null $user_updated
 * @property string|null $time_updated
 */
class TournamentView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tournament_view';
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
            [['id', 'tournament_date_count'], 'integer'],
            [['name'], 'required'],
            [['is_active'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['user_created', 'user_updated'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'name'                  => Yii::t('app', 'Name'),
            'is_active'             => Yii::t('app', 'Is Active'),
            'tournament_date_count' => Yii::t('app', 'Tournament Date Count'),
            'user_created'          => Yii::t('app', 'User Created'),
            'time_created'          => Yii::t('app', 'Time Created'),
            'user_updated'          => Yii::t('app', 'User Updated'),
            'time_updated'          => Yii::t('app', 'Time Updated'),
        ];
    }
}
