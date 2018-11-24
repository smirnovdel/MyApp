<?php

namespace app\models\handbk;

use Yii;
use app\models\handbk\Category;

/**
 * This is the model class for table "products_ref_subcategory".
 *
 * @property int $id
 * @property string $value
 * @property int $caregory_id
 *
 * @property Category $caregory
 */
class Subcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_ref_subcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['caregory_id'], 'default', 'value' => null],
            [['caregory_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [
                ['caregory_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['caregory_id' => 'id']
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
            'value' => 'Value',
            'caregory_id' => 'Caregory ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaregory()
    {
        return $this->hasOne(Category::className(), ['id' => 'caregory_id']);
    }

    /**
     * {@inheritdoc}
     * @return SubcategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubcategoryQuery(get_called_class());
    }
}
