<?php

use yii\db\Migration;

/**
 * Class m190719_071540_create_product_gallery
 */
class m190719_071540_create_product_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE if not exists `product_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_gallery_product_id` (`product_id`),
  CONSTRAINT `fk_product_gallery_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190719_071540_create_product_gallery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190719_071540_create_product_gallery cannot be reverted.\n";

        return false;
    }
    */
}
