<?php

namespace app\models\props;

use Yii;
use app\models\props\PropsJewelry;
use app\models\handbk\InsertGems;

/**
 * This is the model class for table "products_insert_count".
 *
 * @property int $id
 * @property int $product_id
 * @property int $value
 * @property int $ref_insert_gems_id
 *
 * @property PropsJewelry $product
 * @property InsertGems $refInsertGems
 */
class InsertCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_insert_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'value', 'ref_insert_gems_id'], 'required'],
            [['product_id', 'value', 'ref_insert_gems_id'], 'default', 'value' => null],
            [['product_id', 'value', 'ref_insert_gems_id'], 'integer'],
            [
                ['product_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => PropsJewelry::className(),
                'targetAttribute' => ['product_id' => 'product_id']
            ],
            [
                ['ref_insert_gems_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => InsertGems::className(),
                'targetAttribute' => ['ref_insert_gems_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'ref_insert_gems_id' => 'Ref Insert Gems ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(PropsJewelry::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefInsertGems()
    {
        return $this->hasOne(InsertGems::className(), ['id' => 'ref_insert_gems_id']);
    }

    /**
     * {@inheritdoc}
     * @return InsertCountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InsertCountQuery(get_called_class());
    }
}
