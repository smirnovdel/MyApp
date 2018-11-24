<?php

namespace app\models\handbk;

use Yii;
use app\models\props\PropsJewelry;
/**
 * This is the model class for table "products_ref_material".
 *
 * @property int $id
 * @property string $value
 *
 * @property PropsJewelry[] $productsPropsJewelries
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_material';
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
        return $this->hasMany(PropsJewelry::className(), ['material_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialQuery(get_called_class());
    }
}
