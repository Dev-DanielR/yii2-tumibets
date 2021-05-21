<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fixture;

/**
 * FixtureSearch represents the model behind the search form of `app\models\Fixture`.
 */
class FixtureSearch extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tournament_date_id', 'teamA_id', 'teamB_id', 'teamA_score', 'teamB_score'], 'integer'],
            [['start', 'end'], 'safe'],
            [['is_active'], 'boolean'],
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
        $query = Fixture::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);
        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            'id'                 => $this->id,
            'tournament_date_id' => $this->tournament_date_id,
            'teamA_id'           => $this->teamA_id,
            'teamB_id'           => $this->teamB_id,
            'teamA_score'        => $this->teamA_score,
            'teamB_score'        => $this->teamB_score,
            'start'              => $this->start,
            'end'                => $this->end,
            'is_active'          => $this->is_active,
        ]);

        return $dataProvider;
    }
}
