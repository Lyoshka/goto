<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "tarif".
 *
 * @property integer $id
 * @property string $name
 * @property integer $price
 * @property integer $type
 */
class Tarif extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarif';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'type'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'type' => 'Type',
        ];
    }
}
