<?php

namespace inblank\team\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TeamSearch represents the model behind the search form about `inblank\team\models\Team`.
 */
class TeamSearch extends Team
{
    public $scenario = 'search';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'owner_id'], 'integer'],
            [['slug', 'emblem', 'name', 'description', 'founded_at', 'created_at', 'disbanded_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Team::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'owner_id' => $this->owner_id,
            'founded_at' => $this->founded_at,
            'created_at' => $this->created_at,
            'disbanded_at' => $this->disbanded_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'emblem', $this->emblem])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
