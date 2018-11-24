<?php

namespace app\models\handbk;

/**
 * This is the ActiveQuery class for [[Zodiac]].
 *
 * @see Zodiac
 */
class ZodiacQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Zodiac[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Zodiac|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
