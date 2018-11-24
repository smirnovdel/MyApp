<?php

namespace app\models\handbk;

use Yii;

/**
 * This is the model class for table "products_ref_material_color".
 *
 * @property int $id
 * @property string $value
 */
class MaterialColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_material_color';
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
     * {@inheritdoc}
     * @return MaterialColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialColorQuery(get_called_class());
    }
}
