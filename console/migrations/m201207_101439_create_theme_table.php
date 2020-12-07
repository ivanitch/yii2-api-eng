<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%theme}}`.
 */
class m201207_101439_create_theme_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%theme}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->unsigned()->notNull(),
            'level_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(100)->notNull(),
            'image' => $this->string(100)->notNull()->defaultValue(''),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%theme}}');
    }
}
