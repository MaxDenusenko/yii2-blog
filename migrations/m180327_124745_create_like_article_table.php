<?php

use yii\db\Migration;

/**
 * Handles the creation of table `like_article`.
 */
class m180327_124745_create_like_article_table extends Migration
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

        $this->createTable('{{%like_article}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->date()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'ip' => $this->string(20)->notNull(),
            'user_agent' => $this->text()->defaultValue(null),
            'user_id' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->addForeignKey('like_article_article_id_fk', '{{%like_article}}', 'article_id', '{{%article}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('like_article_user_id_fk', '{{%like_article}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%like_article}}');
    }
}
