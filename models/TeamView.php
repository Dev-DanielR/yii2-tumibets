<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "team_view".
 *
 * @property int         $id
 * @property string      $name
 * @property string|null $image_path
 * @property bool        $is_active
 * @property string|null $user_created
 * @property string      $time_created
 * @property string|null $user_updated
 * @property string|null $time_updated
 */
class TeamView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_view';
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
            [['id'], 'integer'],
            [['name'], 'required'],
            [['is_active'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['image_path'], 'string', 'max' => 256],
            [['user_created', 'user_updated'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'name'         => Yii::t('app', 'Name'),
            'image_path'   => Yii::t('app', 'Image Path'),
            'is_active'    => Yii::t('app', 'Is Active'),
            'user_created' => Yii::t('app', 'User Created'),
            'time_created' => Yii::t('app', 'Time Created'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'time_updated' => Yii::t('app', 'Time Updated'),
        ];
    }

}
