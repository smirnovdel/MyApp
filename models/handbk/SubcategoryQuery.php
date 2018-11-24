<?php

namespace app\models\handbk;

/**
 * This is the ActiveQuery class for [[Subcategory]].
 *
 * @see Subcategory
 */
class SubcategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Subcategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Subcategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
