<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word}}`.
 */
class m201207_110644_create_word_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%word}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'translation' => $this->string()->notNull(),
            'transcription' => $this->string()->notNull(),
            'example' => $this->text(),
            'sound' => $this->string(100)->notNull()->defaultValue(''),
            'image' => $this->string(100)->notNull()->defaultValue(''),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%word}}');
    }
}
