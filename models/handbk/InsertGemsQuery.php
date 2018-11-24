<?php

namespace app\models\handbk;

/**
 * This is the ActiveQuery class for [[InsertGems]].
 *
 * @see InsertGems
 */
class InsertGemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InsertGems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InsertGems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
