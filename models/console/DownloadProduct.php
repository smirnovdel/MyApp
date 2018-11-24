<?php

namespace app\models\console;

use yii\base\ErrorException;
use yii\db\Command;
use yii\db\ActiveQuery;
use yii;

class DownloadProduct
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
     * Записывает таблицы продукта
     */
    public function downloadHandbk($file)
    {
        $arProduct = $this->getArDb($file);

        $db = Yii::$app->db;
        $outerTransaction = $db->beginTransaction();
        $response = 0;
        try {
            $query = "
                SELECT
                    *
                FROM
                    products_ref_subcategory
            ";
            $subcategories = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($subcategories as $values) {
                $arSubcategories[$values["caregory_id"]][$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_category
            ";
            $categories = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($categories as $values) {
                $arCategories[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_material
            ";
            $materials = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($materials as $values) {
                $arMaterials[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_material_color
            ";
            $materialsColor = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($materialsColor as $values) {
                $arMaterialsColor[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_insert_gems
            ";
            $insertGems = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($insertGems as $values) {
                $arInsertGems[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_subjects
            ";
            $subjects = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($subjects as $values) {
                $arSubjects[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_product_group
            ";
            $productGroups = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($productGroups as $values) {
                $arProductGroups[$values["value"]] = $values["id"];
            }

            $query = "
                SELECT
                    *
                FROM
                    products_ref_zodiac
            ";
            $zodiacSigns = yii\db\ActiveRecord::findBySql($query)->asArray()->all();

            foreach ($zodiacSigns as $values) {
                $arZodiacSigns[$values["value"]] = $values["id"];
            }

            $allCount = count($arProduct);
            $count = $allCount;
            echo "Выполненно 0:% \n";
            foreach ($arProduct as $arProductProps) {
                $query = "
                    INSERT  INTO products(product_type, active, sort, code, name) 
                    VALUES (
                      'jewelry',
                      '{$arProductProps["ACTIVE"]}',
                      '{$arProductProps["SORT"]}',
                      '{$arProductProps["CODE"]}',
                      '{$arProductProps["NAME"]}'
                      )  ON CONFLICT  DO NOTHING
                      ;
                ";
                $insert = $db->createCommand($query)->execute();

                $id = $db->lastInsertID;

                if ($insert) {
                    if (!empty($arProductProps["CATEGORY"])) {
                        $categoryId = $arCategories[$arProductProps["CATEGORY"]];
                    } else {
                        $categoryId = false;
                    }

                    if (!empty($arProductProps["SUBCATEGORY"]) && $categoryId != "NULL") {
                        $subcategorie = "'" . $arSubcategories[$categoryId][$arProductProps["SUBCATEGORY"]] . "'";
                    } else {
                        $subcategorie = "NULL";
                    }


                    $categoryId = $categoryId ? "'" .$categoryId . "'" : "NULL";

                    $materialsColor = self::getFieldQuery($arProductProps["MATERIAL_COLOR"], $arMaterialsColor);

                    $subjectId = self::getFieldQuery($arProductProps["SUBJECTS"], $arSubjects);

                    $productGroupId = self::getFieldQuery($arProductProps["PRODUCT_GROUP"], $arProductGroups);

                    $zodiacId = self::getFieldQuery($arProductProps["ZODIAC_SIGN"], $arZodiacSigns);

                    $materialId = self::getFieldQuery($arProductProps["MATERIAL"], $arMaterials);

                    $artnumber = self::getFieldQuery($arProductProps["ARTNUMBER"]);

                    $techName = self::getFieldQuery($arProductProps["TECH_NAME"]);



                    $query = "
                    INSERT INTO products_props_jewelry (
                        product_id,
                        subcaregory_id,
                        category_id,
                        material_id,
                        product_group_id,
                        material_color_id,
                        subjects_id,
                        zodiac_sign,
                        article,
                        tech_name
                    ) VALUES (
                        '{$id}',
                        {$subcategorie},
                        {$categoryId},
                        {$materialId},
                        {$productGroupId},
                        {$materialsColor},
                        {$subjectId},
                        {$zodiacId},
                        {$artnumber},
                        {$techName}
                      );
                    ";
                    $db->createCommand($query)->execute();

                    if (!empty($arProductProps["INSERTS_COUNT"])) {
                        foreach ($arProductProps["INSERTS_COUNT"] as $name => $countInsert) {
                            $insertGemsId = $arInsertGems[$name];
                            $query = "
                            INSERT INTO products_insert_count (
                                product_id,
                                value,
                                ref_insert_gems_id
                            ) VALUES (
                                '{$id}',
                                '{$countInsert}',
                                '{$insertGemsId}'
                            )
                           ";
                            $db->createCommand($query)->execute();
                        }
                    }
                }
                $count -= 1;
                echo "Выполненно " . (100 - ($count * 100 / $allCount)) . "\n";
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

    private function getFieldQuery($productProps = false, $handbook = false)
    {
        if (!empty($productProps)) {
            if ($handbook) {
                $field = "'" . $handbook[$productProps] . "'";
            } else {
                $field = "'" . $productProps . "'";
            }
        } else {
            $field = "NULL";
        }

        return $field;
    }


}
