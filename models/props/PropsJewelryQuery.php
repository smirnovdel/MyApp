<?php

namespace app\models\props;

/**
 * This is the ActiveQuery class for [[PropsJewelry]].
 *
 * @see PropsJewelry
 */
class PropsJewelryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PropsJewelry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PropsJewelry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
