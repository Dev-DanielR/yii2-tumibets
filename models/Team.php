<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property bool $is_active
 *
 * @property Fixture[] $fixtures
 * @property Fixture[] $fixtures0
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'image'], 'required'],
            [['id'], 'integer'],
            [['is_active'], 'boolean'],
            [['name'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 256],
            [['name'], 'unique'],
            [['id'], 'unique'],
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
            'image'     => 'Image',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Fixtures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFixtures()
    {
        return array_unique(array_merge(
            $this->hasMany(Fixture::className(), ['teamA_id' => 'id']),
            $this->hasMany(Fixture::className(), ['teamB_id' => 'id'])
        ));
    }
}
