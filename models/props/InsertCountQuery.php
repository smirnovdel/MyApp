<?php

namespace app\models\props;

/**
 * This is the ActiveQuery class for [[InsertCount]].
 *
 * @see InsertCount
 */
class InsertCountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InsertCount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InsertCount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
