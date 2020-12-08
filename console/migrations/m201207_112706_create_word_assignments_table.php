<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word_assignments}}`.
 */
class m201207_112706_create_word_assignments_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%word_assignments}}', [
            'theme_id' => $this->integer()->notNull(),
            'word_id' => $this->integer()->notNull(),

        ]);

        $this->addPrimaryKey('{{%pk-word_assignments}}', '{{%word_assignments}}', ['theme_id', 'word_id']);

        $this->createIndex('{{%idx-word_assignments-theme_id}}', '{{%word_assignments}}', 'theme_id');
        $this->createIndex('{{%idx-word_assignments-word_id}}', '{{%word_assignments}}', 'word_id');

        $this->addForeignKey('{{%fk-word_assignments-theme_id}}', '{{%word_assignments}}', 'theme_id', '{{%theme}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-word_assignments-word_id}}', '{{%word_assignments}}', 'word_id', '{{%word}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%word_assignments}}');
    }
}
