<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "net_city".
 *
 * @property int $id
 * @property int|null $country_id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $region
 * @property string|null $postal_code
 * @property string|null $latitude
 * @property string|null $longitude
 */
class NetCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'net_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id'], 'integer'],
            [['name_ru', 'name_en'], 'string', 'max' => 100],
            [['region'], 'string', 'max' => 2],
            [['postal_code', 'latitude', 'longitude'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'region' => 'Region',
            'postal_code' => 'Postal Code',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}
