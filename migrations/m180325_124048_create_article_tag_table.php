<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 */
class m180325_124048_create_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_tag}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-article_tag-article_id', '{{%article_tag}}', 'article_id');
        $this->createIndex('idx-article_tag-tag_id', '{{%article_tag}}', 'tag_id');

        $this->addForeignKey('fk-article_tag-article_id', '{{%article_tag}}', 'article_id', '{{%article}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-article_tag-tag_id', '{{%article_tag}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
    }
}
