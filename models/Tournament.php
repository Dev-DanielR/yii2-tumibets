<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament".
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property int $user_created
 * @property string $time_created
 * @property int|null $user_updated
 * @property string|null $time_updated
 *
 * @property User $userCreated
 * @property User $userUpdated
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
            [['name', 'user_created'], 'required'],
            [['is_active'], 'boolean'],
            [['user_created', 'user_updated'], 'integer'],
            [['time_created', 'time_updated'], 'safe'],
            [['name'], 'string', 'max' => 45],
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
            'id'           => 'ID',
            'name'         => 'Name',
            'is_active'    => 'Is Active',
            'user_created' => 'User Created',
            'time_created' => 'Time Created',
            'user_updated' => 'User Updated',
            'time_updated' => 'Time Updated',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($insert) {
            $this->user_created = Yii::$app->user->identity->id;
            $this->time_created = date('Y-m-d H:i:s');
        } else {
            $this->user_updated = Yii::$app->user->identity->id;
            $this->time_updated = date('Y-m-d H:i:s');
        }
        return true;
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
