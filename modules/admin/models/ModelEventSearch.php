<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserInfo;

/**
 * UserInfoSearch represents the model behind the search form about `app\models\UserInfo`.
 */
class ModelEventSearch extends UserInfo
{
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id', 'id', 'id2', 'prepend_phone', 'phone', 'category2_id', 'subcategory_id',
                    'category_id', 'birth', 'address', 'weight', 
                    'collar', 'chest', 'waist', 'hips', 'shoe', 'servCatName', 
                    'add_management', 'subcategory_key'
                ], 'integer'
            ],
            [
                [
                    'gender', 'gender2', 'name', 'name2',
                    'last_name', 'type', 'active',
                    'nationality', 'country', 'city', 'email',
                    'ethnicity', 'height', 'suit', 'pant', 
                    'hair', 'hair_length', 'eye', 'language', 
                    'visa_status', 'specialization', 'subcategory'
                ], 
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
//    public function scenarios()
//    {
//        // bypass scenarios() implementation in the parent class
//        return Model::scenarios();
//    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $list_id = \app\models\ModelCategory::getListIdCategoriesForCategory(7);
        
        $query = UserInfo::find();
        $query->select([
            "ui.id",
            "ui.user_id",
            "ui.name",
            "ui.phone",
//            "ui.type",
            "(
                SELECT CONCAT('{', GROUP_CONCAT(CONCAT('\"', mc.id, '\":\"', mc.`name`, '\"') SEPARATOR ','), '}')
                FROM user_category uc 
                LEFT JOIN model_category mc ON mc.id = uc.category_id
                WHERE uc.info_user_id = ui.id
            ) AS type",
            "u.email",
            "ui.subcategory",
            "ui.last_name",
            "ui.last_name",
            "ui.gender",
            "ui.nationality",
            "ui.country",
            "ui.city",
            "ui.ethnicity",
            "ui.visa_status",
            "ui.specialization",
            "uc.active",
            "(
                SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',ms.id, '\":', '\"', ms.`name`, '\"') SEPARATOR ','), '}')
                FROM user_subcategory us
                LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id
                WHERE us.info_user_id = ui.id
            ) AS subcategory",
            "IFNULL(
                (
                    SELECT src
                    FROM user_media
                    WHERE info_user_id = ui.id
                    AND `type` IN ('image', 'polaroid')
                    ORDER BY `order`
                    LIMIT 1
                ), 
                'diva-logo.png'
            ) AS logo",
        ]);
        $query->from('user_category uc');
        $query->leftJoin('user_info ui', 'uc.info_user_id = ui.id');
        $query->leftJoin('user u', 'ui.user_id = u.id');
        
        $this->load($params);
        
        if($this->type){
            $query->where(['uc.category_id' => $this->type]);
        }else{
            if($this->category_id || $this->category2_id){
                $query->where(['uc.category_id' => $this->category2_id ? $this->category2_id : $this->category_id]);
            }else{
                $query->where(['uc.category_id' => $list_id]);
            }
        }
        
        
        if($this->subcategory_key){
            $query->leftJoin('user_subcategory us', 'us.info_user_id = ui.id');
            $query->andFilterWhere(['us.subcategory_id' => $this->subcategory_key]);
        }
        
        
        if($this->subcategory_id){
            $query->leftJoin('user_subcategory us', 'us.info_user_id = ui.id');
            $query->andFilterWhere(['us.subcategory_id'=> array_keys($this->subcategory_id)]);
        }
        
        if($this->phone){
            $query->andFilterWhere(['ui.phone'=> "{$this->prepend_phone}/{$this->phone}"]);
        }
        
        if(!empty($this->specialization)){
            $specialization = array_keys($this->specialization);
            $query->andWhere(['REGEXP', 'ui.specialization', "(".implode('|', $specialization).")"]);
        }
        
        if(!empty($this->city)){
            $query->andWhere(['REGEXP', 'ui.city', "(".implode('|', $this->city).")"]);
        }
        
        if(!empty($this->ethnicity)){
            $query->andWhere(['REGEXP', 'ui.ethnicity', "(".implode('|', $this->ethnicity).")"]);
        }
        
        if(!empty($this->language)){
            $query->andWhere(['REGEXP', 'ui.language', "(".implode('|', $this->language).")"]);
        }
        
        $query->andFilterWhere([
            'ui.id' => $this->id2,
            'ui.gender' => $this->gender2,

        ]);
        
        $query->andFilterWhere(['like', 'ui.name', $this->name2]);
        
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        
        if(!isset($params['sort'])){
            $query->orderBy('uc.created_at DESC');
        }
        
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'ui.id' => $this->id,
            'ui.gender' => $this->gender,
            'ui.user_id' => $this->user_id,
            'ui.birth' => $this->birth,
            'ui.address' => $this->address,
            'ui.weight' => $this->weight,
            'ui.collar' => $this->collar,
            'ui.chest' => $this->chest,
            'ui.waist' => $this->waist,
            'ui.hips' => $this->hips,
            'ui.shoe' => $this->shoe,
            'ui.type' => $this->type,
            'uc.active' => $this->active,
        ]);
        
        $query->andFilterWhere(['like', 'ui.name', $this->name])
            ->andFilterWhere(['like', 'ui.last_name', $this->last_name])
            ->andFilterWhere(['like', 'ui.gender', $this->gender])
            ->andFilterWhere(['like', 'ui.nationality', $this->nationality])
            ->andFilterWhere(['like', 'ui.country', $this->country])
            ->andFilterWhere(['like', 'ui.height', $this->height])
            ->andFilterWhere(['like', 'ui.suit', $this->suit])
            ->andFilterWhere(['like', 'ui.pant', $this->pant])
            ->andFilterWhere(['like', 'ui.hair', $this->hair])
            ->andFilterWhere(['like', 'ui.hair_length', $this->hair_length])
            ->andFilterWhere(['like', 'ui.eye', $this->eye])
            ->andFilterWhere(['like', 'ui.visa_status', $this->visa_status])
            ->andFilterWhere(['like', 'u.subcategory', $this->subcategory])
            ->andFilterWhere(['like', 'u.email', $this->email]);


        return $dataProvider;
    }
}
