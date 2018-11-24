<?php

namespace app\models\handbk;

use Yii;
use app\models\props\InsertCount;
/**
 * This is the model class for table "products_ref_insert_gems".
 *
 * @property int $id
 * @property string $value
 *
 * @property InsertCount[] $productsInsertCounts
 */
class InsertGems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_insert_gems';
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
    public function getProductsInsertCounts()
    {
        return $this->hasMany(InsertCount::className(), ['ref_insert_gems_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InsertGemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InsertGemsQuery(get_called_class());
    }
}
