<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usergroups}}`.
 */
class m200829_192458_create_usergroups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->createTable("usergroups", [
		    "id" => $this->primaryKey(),
		    "name" => $this->string(),
		    "created_by" => $this->integer()->notNull(),
		    "created_at" => $this->timestamp()->notNull(),
		    "updated_at" => $this->timestamp()->notNull(),
	    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usergroups}}');
    }
}
