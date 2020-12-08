<?php

namespace api\models;

use api\core\entities\Theme;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ThemeSearch extends Model
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $category = $params['category'] ?? null;
        $level = $params['level'] ?? null;

        if (!$category) throw new \RuntimeException('Required argument category.');
        if (!$level) throw new \RuntimeException('Required argument level.');

        $query = Theme::find()
            ->where(['category_id' => $category])
            ->andWhere(['level_id' => $level]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => 1,
                'pageParam' => 'page',
                'forcePageParam' => false,
                'pageSizeParam'  => false,
                'validatePage'   => false,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}