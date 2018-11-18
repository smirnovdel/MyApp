<?php

use yii\db\Migration;

/**
 * Class m181104_165109_reference_books
 */
class m181104_165109_reference_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $query = [
            "CREATE TABLE s_products (
            id SERIAL PRIMARY KEY,
            product_type VARCHAR(45) NULL,
            code VARCHAR(45) NULL UNIQUE,
            active CHAR(1) NULL,
            sort INT NULL,
            name VARCHAR(255) NULL);",

            "CREATE TABLE s_products_ref_product_group (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL UNIQUE );",
            "COMMENT ON TABLE s_products_ref_product_group IS 'Справочник:Товарная группа';",

            "CREATE TABLE s_products_ref_material (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL UNIQUE);",
            "COMMENT ON TABLE s_products_ref_material IS 'Справочник:Металл';",

            "CREATE TABLE s_products_ref_material_color (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL UNIQUE);",
            "COMMENT ON TABLE s_products_ref_material_color IS 'Справочник:Цвет материала';",

            "CREATE TABLE s_products_ref_insert_gems (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL UNIQUE);",
            "COMMENT ON TABLE s_products_ref_insert_gems IS 'Справочник:Вставки';",

            "CREATE TABLE s_products_ref_category (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL UNIQUE);
            ",
            "COMMENT ON TABLE s_products_ref_category IS 'Справочник:Категории';",

            "CREATE TABLE s_products_ref_subcategory (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL ,
            caregory_id INT REFERENCES s_products_ref_category(id));
            ",
            "COMMENT ON TABLE s_products_ref_subcategory IS 'Справочник:Подкатегории';",

            "CREATE TABLE s_products_ref_subjects (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL)",
            "COMMENT ON TABLE s_products_ref_subjects IS 'Справочник:Тематика';",

            "CREATE TABLE s_products_ref_zodiac (
            id SERIAL PRIMARY KEY,
            value VARCHAR(255) NOT NULL)",
            "COMMENT ON TABLE s_products_ref_zodiac IS 'Справочник:Знаки зодиака';",

            "CREATE TABLE s_products_props_jewelry (
            product_id INT REFERENCES s_products(id) PRIMARY KEY,
            subcaregory_id INT NULL,
            category_id INT NULL,
            product_group_id INT REFERENCES s_products_ref_product_group(id) NULL,
            subjects_id INT NULL,
            material_id INT REFERENCES s_products_ref_material(id) NULL,
            material_color_id INT NULL,
            zodiac_sign VARCHAR(255) NULL,
            article VARCHAR(255) NULL,
            tech_name VARCHAR(255) NULL,
            purity INT NULL);",
            "COMMENT ON TABLE s_products_props_jewelry IS 'Не множественные свойства продукта';",
            "COMMENT ON COLUMN s_products_props_jewelry.product_id IS 'Ссылка на продук';",
            "COMMENT ON COLUMN s_products_props_jewelry.subcaregory_id IS 'Ссылка на справочник - Подкатегории';",
            "COMMENT ON COLUMN s_products_props_jewelry.subjects_id IS 'Знак зодиака';","
            COMMENT ON COLUMN s_products_props_jewelry.material_id IS 'Ссылка на справочник - Металл';","
            COMMENT ON COLUMN s_products_props_jewelry.zodiac_sign IS 'Ссылка на справочник - Цвет материала';","
            COMMENT ON COLUMN s_products_props_jewelry.tech_name IS 'Техническое наименование';","
            COMMENT ON COLUMN s_products_props_jewelry.purity IS 'Проба';",

            //на один продукт может быть несколько строк(содержит количество и ссылается на вставку и продукт)
            "CREATE TABLE s_products_insert_count (
            id SERIAL PRIMARY KEY,
            product_id INT REFERENCES s_products_props_jewelry(product_id) NOT NULL,
            value INT NOT NULL,
            ref_insert_gems_id INT REFERENCES s_products_ref_insert_gems(id) NOT NULL);",
            "COMMENT ON TABLE s_products_insert_count IS 'Множественное свойство:Количество вставок';"
        ];

        foreach ($query as $sql) {
            $this->db->createCommand($sql)->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $query = [

            "DROP TABLE IF EXISTS s_products_recomended_pro",

            "DROP TABLE IF EXISTS s_products_insert_count",

            "DROP TABLE IF EXISTS s_products_props_jewelry",

            "DROP TABLE IF EXISTS s_products_ref_product_group ",

            "DROP TABLE IF EXISTS s_products_ref_material",

            "DROP TABLE IF EXISTS s_products_ref_material_color",

            "DROP TABLE IF EXISTS s_products_ref_insert_gems",

            "DROP TABLE IF EXISTS s_products_ref_subcategory",

            "DROP TABLE IF EXISTS s_products_ref_category",

            "DROP TABLE IF EXISTS s_products_ref_subjects",

            "DROP TABLE IF EXISTS s_products_ref_zodiac",

            "DROP TABLE IF EXISTS s_products",

        ];

        foreach ($query as $sql) {
            $this->db->createCommand($sql)->execute();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181104_165109_reference_books cannot be reverted.\n";

        return false;
    }
    */
}
