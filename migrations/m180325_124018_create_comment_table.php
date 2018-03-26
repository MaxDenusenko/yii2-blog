<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180325_124018_create_comment_table extends Migration
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

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-post-user_id', 'comment', 'user_id');
        $this->createIndex('idx-article_id', 'comment', 'article_id');

        $this->addForeignKey('fk-post-user_id', 'comment', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-article_id', 'comment', 'article_id', 'article', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
