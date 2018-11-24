<?php

namespace app\models\handbk;

use Yii;

/**
 * This is the model class for table "products_ref_zodiac".
 *
 * @property int $id
 * @property string $value
 */
class Zodiac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_zodiac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
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
     * @return ZodiacQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZodiacQuery(get_called_class());
    }
}
