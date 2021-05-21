<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_date".
 *
 * @property int $id
 * @property int $tournament_id
 * @property string|null $name
 * @property bool $is_active
 *
 * @property Fixture[] $fixtures
 * @property Tournament $tournament
 */
class TournamentDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tournament_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tournament_id'], 'required'],
            [['id', 'tournament_id'], 'integer'],
            [['is_active'], 'boolean'],
            [['name'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'tournament_id' => 'Tournament ID',
            'name'          => 'Name',
            'is_active'     => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Fixtures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixtures()
    {
        return $this->hasMany(Fixture::className(), ['tournament_date_id' => 'id']);
    }

    /**
     * Gets query for [[Tournament]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }
}
