<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin', // password: 12345678
            'auth_key' => 'NcBMXcpL2fU9w5oJXB0crexMjRMPAXd0',
            'password_hash' => '$2y$13$RM/hpBAaqBLDbpLzhiZyfuFQrVh5MXnhFPVQVMDdjEC4395tMzuX.',
            'password_reset_token' => null,
            'verification_token' => null,
            'email' => 'admin@gmail.com',
            'status' => 10,
            'created_at' => 1606138472,
            'updated_at' => 1606138472
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
