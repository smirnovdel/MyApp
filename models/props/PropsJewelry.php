<?php

namespace app\models\props;

use Yii;
use app\models\props\InsertCount;
use app\models\Product;
use app\models\handbk\Material;
use app\models\handbk\ProductGroup;

/**
 * This is the model class for table "products_props_jewelry".
 *
 * @property int $product_id Ссылка на продук
 * @property int $subcaregory_id Ссылка на справочник - Подкатегории
 * @property int $category_id
 * @property int $product_group_id
 * @property int $subjects_id Знак зодиака
 * @property int $material_id Ссылка на справочник - Металл
 * @property int $material_color_id
 * @property string $zodiac_sign Ссылка на справочник - Цвет материала
 * @property string $article
 * @property string $tech_name Техническое наименование
 * @property int $purity Проба
 *
 * @property InsertCount[] $productsInsertCounts
 * @property Product $product
 * @property Material $material
 * @property ProductGroup $productGroup
 */
class PropsJewelry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_props_jewelry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [
                [
                    'product_id',
                    'subcaregory_id',
                    'category_id',
                    'product_group_id',
                    'subjects_id',
                    'material_id',
                    'material_color_id',
                    'purity'
                ],
                'default',
                'value' => null
            ],
            [
                [
                    'product_id',
                    'subcaregory_id',
                    'category_id',
                    'product_group_id',
                    'subjects_id',
                    'material_id',
                    'material_color_id',
                    'purity'
                ],
                'integer'
            ],
            [['zodiac_sign', 'article', 'tech_name'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
            [
                ['product_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::className(),
                'targetAttribute' => ['product_id' => 'id']
            ],
            [
                ['material_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Material::className(),
                'targetAttribute' => ['material_id' => 'id']
            ],
            [
                ['product_group_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductGroup::className(),
                'targetAttribute' => ['product_group_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'subcaregory_id' => 'Subcaregory ID',
            'category_id' => 'Category ID',
            'product_group_id' => 'Product Group ID',
            'subjects_id' => 'Subjects ID',
            'material_id' => 'Material ID',
            'material_color_id' => 'Material Color ID',
            'zodiac_sign' => 'Zodiac Sign',
            'article' => 'Article',
            'tech_name' => 'Tech Name',
            'purity' => 'Purity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsInsertCounts()
    {
        return $this->hasMany(InsertCount::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductGroup()
    {
        return $this->hasOne(ProductGroup::className(), ['id' => 'product_group_id']);
    }

    /**
     * {@inheritdoc}
     * @return PropsJewelryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropsJewelryQuery(get_called_class());
    }
}
