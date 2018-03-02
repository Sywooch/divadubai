<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContentMedia;

/**
 * ContentMediaSearch represents the model behind the search form about `app\models\ContentMedia`.
 */
class ContentMediaSearch extends ContentMedia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'target_id'], 'integer'],
            [['type', 'image', 'video', 'source'], 'safe'],
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
        $query = ContentMedia::find();

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
            'target_id' => $this->target_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }
}
