<?php

namespace app\models;

use Yii;
use app\models\props\PropsJewelry;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $product_type
 * @property string $code
 * @property string $active
 * @property int $sort
 * @property string $name
 *
 * @property PropsJewelry $productsPropsJewelry
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => null],
            [['sort'], 'integer'],
            [['product_type', 'code'], 'string', 'max' => 45],
            [['active'], 'string', 'max' => 1],
            [['name'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_type' => 'Product Type',
            'code' => 'Code',
            'active' => 'Active',
            'sort' => 'Sort',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPropsJewelry()
    {
        return $this->hasOne(PropsJewelry::className(), ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
