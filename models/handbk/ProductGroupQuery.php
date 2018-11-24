<?php

namespace app\models\handbk;

/**
 * This is the ActiveQuery class for [[ProductGroup]].
 *
 * @see ProductGroup
 */
class ProductGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
