<?php

namespace backend\forms;

use core\entities\Category\Category;
use core\entities\Level\Level;
use core\entities\Theme\Theme;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ThemeSearch extends Model
{
    public $id;
    public $name;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Theme::find()
            ->select(['theme.*', 'COUNT(w.word_id) AS count'])
            ->joinWith(['wordAssignments w'])
            ->groupBy('theme.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => 20,
                'pageSizeParam' => false
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'name',
                'category_id',
                'level_id',
                'wordsCount' => [
                    'asc' => ['count' => SORT_ASC],
                    'desc' => ['count' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function levelsList(): array
    {
        return ArrayHelper::map(Level::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }
}