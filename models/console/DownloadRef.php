<?php

namespace app\models\console;

use yii\base\ErrorException;
use yii\db\Command;
use yii\db\ActiveQuery;
use yii;

class DownloadRef
{
    /**
     * @param $file
     * @return bool|mixed
     * Читает файл, возвращает массив данных
     */
    private function getArDb($file)
    {
        $file = file_get_contents('files/' . $file);
        $arDb = json_decode($file, true);

        if (!$arDb) {
            $respons = false;
        } else {
            $respons = $arDb;
        }

        return $respons;
    }

    /**
     * @param $file
     * @return bool|int
     * @throws yii\db\Exception
     * Записывает таблицы - справочники из файла
     */
    public function downloadHandbk($file)
    {
        $arDb = $this->getArDb($file);

        $db = Yii::$app->db;
        $outerTransaction = $db->beginTransaction();

        try {
            $response = $db->createCommand()->batchInsert(
                's_products_ref_product_group',
                ['value'],
                $arDb["productGroup"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_material',
                ['value'],
                $arDb["material"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_material_color',
                ['value'],
                $arDb["materialCoor"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_category',
                ['value'],
                $arDb["category"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_insert_gems',
                ['value'],
                $arDb["insert"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_subjects',
                ['value'],
                $arDb["subjects"]
            )->execute();

            $response =+ $db->createCommand()->batchInsert(
                's_products_ref_zodiac',
                ['value'],
                $arDb["zodiac"]
            )->execute();

            foreach ($arDb["subcategory"] as $category => $arSub) {
                foreach ($arSub as $subCategory) {
                    $query = "
                        INSERT INTO s_products_ref_subcategory (value, caregory_id) 
                            (SELECT '{$subCategory}', id FROM s_products_ref_category
                             WHERE value = '{$category}');
                    ";
                    $response =+ $db->createCommand($query)->execute();

                }
            }

            $outerTransaction->commit();

        } catch (\Exception $e) {
            $outerTransaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $outerTransaction->rollBack();
        }

        return $response;
    }


}
