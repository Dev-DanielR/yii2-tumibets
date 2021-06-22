<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Bet;

/**
 * BetForm is the model behind user bet form.
 */
class BetForm extends Model
{
    public $fixture_id;
    public $user_id;
    public $teamA_score;
    public $teamB_score;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fixture_id', 'teamA_score', 'teamB_score'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teamA_score'  => Yii::t('app', 'Team A Score'),
            'teamB_score'  => Yii::t('app', 'Team B Score'),
        ];
    }

    /**
     * Registers a bet
     * @return bool whether the user was created successfully.
     */
    public function register()
    {
        $model = new Bet();
        if ($this->teamA_score !== null && $this->teamB_score !== null){
            $model->user_id     = Yii::$app->user->identity->id;
            $model->fixture_id  = $this->fixture_id;
            $model->teamA_score = $this->teamA_score;
            $model->teamB_score = $this->teamB_score;
            $model->is_active   = 1;
            return $model->save();
        }
        return false;
    }
}