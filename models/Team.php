<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image_path
 * @property bool $is_active
 * @property int $user_created
 * @property string $time_created
 * @property int|null $user_updated
 * @property string|null $time_updated
 *
 * @property Fixture[] $fixtures
 * @property User $userCreated
 * @property User $userUpdated
 */
class Team extends \yii\db\ActiveRecord
{
    public $image;

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
            [['name'], 'required'],
            [['is_active'], 'boolean'],
            [['user_created', 'user_updated'], 'integer'],
            [['time_created', 'time_updated'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['image'], 'file', 'extensions' => 'png'],
            [['name'], 'unique'],
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

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($insert) $this->user_created = Yii::$app->user->identity->id;
        else $this->user_updated = Yii::$app->user->identity->id;
        return true;
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
