<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bet;

/**
 * BetSearch represents the model behind the search form of `app\models\Bet`.
 */
class BetSearch extends Bet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fixture_id', 'user_id', 'teamA_score', 'teamB_score', 'bet_score'], 'integer'],
            [['is_active'], 'boolean'],
            [['created', 'updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Bet::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);
        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            'id'          => $this->id,
            'fixture_id'  => $this->fixture_id,
            'user_id'     => $this->user_id,
            'teamA_score' => $this->teamA_score,
            'teamB_score' => $this->teamB_score,
            'bet_score'   => $this->bet_score,
            'is_active'   => $this->is_active,
            'created'     => $this->created,
            'updated'     => $this->updated,
        ]);

        return $dataProvider;
    }
}
