<?php

namespace backend\forms;

use core\entities\Word\Word;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class WordSearch extends Model
{
    public $id;
    public $name;
    public $translation;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'translation'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Word::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => 20,
                'pageSizeParam' => false
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'translation', $this->translation]);

        return $dataProvider;
    }
}