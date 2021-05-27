<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament".
 *
 * @property int $id
 * @property string|null $name
 * @property bool $is_active
 *
 * @property TournamentDate[] $tournamentDates
 */
class Tournament extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tournament';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => 'Name',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[TournamentDates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentDates()
    {
        return $this->hasMany(TournamentDate::className(), ['tournament_id' => 'id']);
    }
}
