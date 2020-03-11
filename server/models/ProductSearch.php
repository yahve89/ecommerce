<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $brands;
    public $minPrice;
    public $maxPrice;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'catalog_id', 'markup', 'popular'], 'integer'],
            [['alias', 'name', 'price', 'description', 
                'composition', 'mode_of_application', 'brands' , 'minPrice', 'maxPrice'], 'safe'],
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
        $query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
            return $dataProvider;

        if (!empty($this->brands))
            $query->andFilterWhere(['in', 'brand_id', $this->brands]);
        
        if (!empty($this->minPrice) and !empty($this->maxPrice))
            $query->andFilterWhere(['between', 'price', (int)$this->minPrice, (int)$this->maxPrice]);

        $query->andFilterWhere([
            'id' => $this->id,
            'catalog_id' => $this->catalog_id,
            'markup' => $this->markup,
            'popular' => $this->popular,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'composition', $this->composition])
            ->andFilterWhere(['like', 'mode_of_application', $this->mode_of_application]);

        return $dataProvider;
    }
}
