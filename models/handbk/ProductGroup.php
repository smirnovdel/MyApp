<?php

namespace app\models\handbk;

use Yii;
use app\models\props\PropsJewelry;
/**
 * This is the model class for table "products_ref_product_group".
 *
 * @property int $id
 * @property string $value
 *
 * @property PropsJewelry[] $productsPropsJewelries
 */
class ProductGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_product_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['value'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPropsJewelries()
    {
        return $this->hasMany(PropsJewelry::className(), ['product_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductGroupQuery(get_called_class());
    }
}
