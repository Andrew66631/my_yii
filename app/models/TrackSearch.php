<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TrackSearch extends Track
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['track_number', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Track::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_number', $this->track_number]);

        return $dataProvider;
    }
}