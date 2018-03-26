<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180325_123127_create_article_table extends Migration
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

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->date()->notNull(),
            'updated_at' => $this->date(),
            'publisher_at' => $this->date(),
            'title' => $this->string(),
            'description' => $this->text(),
            'content' => $this->text(),
            'image' => $this->string(),
            'viewed' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'category_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-article-title', '{{%article}}', 'title');

        $this->addForeignKey('fk-article-category', '{{%article}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-article-user', '{{%article}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
