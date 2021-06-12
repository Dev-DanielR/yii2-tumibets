<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_session_view".
 *
 * @property int         $id
 * @property string      $username
 * @property bool        $is_admin
 * @property string      $login_timestamp
 * @property string|null $logout_timestamp
 */
class UserSessionView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_session_view';
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
            [['username'], 'required'],
            [['is_admin'], 'boolean'],
            [['login_timestamp', 'logout_timestamp'], 'safe'],
            [['username'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'username'         => Yii::t('app', 'Username'),
            'is_admin'         => Yii::t('app', 'Is Admin'),
            'login_timestamp'  => Yii::t('app', 'Login Timestamp'),
            'logout_timestamp' => Yii::t('app', 'Logout Timestamp'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserSessionView::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);
        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            'id'               => $this->id,
            'is_admin'         => $this->is_admin,
            'login_timestamp'  => $this->login_timestamp,
            'logout_timestamp' => $this->logout_timestamp,
        ]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
