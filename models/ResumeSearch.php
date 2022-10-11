<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Resume;

/**
 * ResumeSearch represents the model behind the search form of `app\models\Resume`.
 */
class ResumeSearch extends Resume
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cost', 'employment_full', 'employment_partial', 'employment_project', 'employment_volunteering', 'employment_internship', 'schedule_full', 'schedule_removable', 'schedule_flexible', 'schedule_tomote', 'schedule_tour', 'update_time', 'user_id', 'exp', 'verify'], 'integer'],
            [['photo', 'surname', 'name', 'patronymic', 'birth_date', 'gender', 'city', 'relocation', 'business_trips', 'vacancy', 'spec', 'specsub', 'cash_type', 'skills', 'description', 'language', 'language_add', 'car'], 'safe'],
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
        $query = Resume::find();

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
            'cost' => $this->cost,
            'employment_full' => $this->employment_full,
            'employment_partial' => $this->employment_partial,
            'employment_project' => $this->employment_project,
            'employment_volunteering' => $this->employment_volunteering,
            'employment_internship' => $this->employment_internship,
            'schedule_full' => $this->schedule_full,
            'schedule_removable' => $this->schedule_removable,
            'schedule_flexible' => $this->schedule_flexible,
            'schedule_tomote' => $this->schedule_tomote,
            'schedule_tour' => $this->schedule_tour,
            'update_time' => $this->update_time,
            'user_id' => $this->user_id,
            'exp' => $this->exp,
            'verify' => $this->verify,
        ]);

        $query->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'relocation', $this->relocation])
            ->andFilterWhere(['like', 'business_trips', $this->business_trips])
            ->andFilterWhere(['like', 'vacancy', $this->vacancy])
            ->andFilterWhere(['like', 'spec', $this->spec])
            ->andFilterWhere(['like', 'specsub', $this->specsub])
            ->andFilterWhere(['like', 'cash_type', $this->cash_type])
            ->andFilterWhere(['like', 'skills', $this->skills])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'language_add', $this->language_add])
            ->andFilterWhere(['like', 'car', $this->car]);

        return $dataProvider;
    }
}
