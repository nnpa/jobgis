<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'create_time', 'firm_id'], 'integer'],
            [['name', 'surname', 'company', 'phone', 'city', 'email', 'password', 'recover_code', 'auth_key', 'access_token', 'patronymic'], 'safe'],
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
    public function search($params,$firm_ids,$empl)
    {
        
        
        $query = Users::find();
        
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
            'id' => $this->id,
            'create_time' => $this->create_time,
            'firm_id' => $this->firm_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'recover_code', $this->recover_code])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic]);
        
            $query->andFilterWhere([
                "type" => $empl

            ]);

        
        if($firm_ids != false){
            $query->andFilterWhere(['firm_id' => $firm_ids]);

        }
        
        return $dataProvider;
    }
    
     public function recruiter($params,$names,$cities)
    {
        
        
        $query = Users::find();
        
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
            'id' => $this->id,
            'create_time' => $this->create_time,
            'firm_id' => $this->firm_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'recover_code', $this->recover_code])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic]);
        

        
            $query->andFilterWhere(['vacancy' => $names]);
            $query->andFilterWhere(['city' => $cities]);

        
        
        return $dataProvider;
    }
}
