<?php

namespace frontend\models\crawlerList;

use common\models\CrawlerList;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CrawlerListSearch represents the model behind the search form of `common\models\CrawlerList`.
 */
class CrawlerListSearch extends CrawlerList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CrawlerListId'], 'integer'],
            [['Name', 'Url', 'CreateDate','Status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = CrawlerList::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'CrawlerListId' => $this->CrawlerListId,
        ]);
        $query->andFilterWhere([
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Url', $this->Url])
            ->andFilterWhere(['like', 'CreateDate', $this->CreateDate]);

        return $dataProvider;
    }
}
