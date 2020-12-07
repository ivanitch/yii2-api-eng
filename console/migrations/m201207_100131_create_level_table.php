<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%level}}`.
 */
class m201207_100131_create_level_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%level}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->unique()->notNull(),
            'code' => $this->string(100)->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%level}}');
    }
}
