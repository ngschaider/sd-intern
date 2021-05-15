<?php

use app\components\Migration;

/**
 * Class m200904_114946_add_frames_table
 */
class m200904_114946_create_frames_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%frames}}", [
			"id" => $this->primaryKey(),
			"name" => $this->string(255)->null(),
			"formationId" => $this->integer()->notNull(),
		]);

		$this->addForeignKey("fk-pictures-formationId", "{{%frames}}", "formationId", "{{%formations}}", "id");
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropForeignKey("fk-pictures-formationId", "{{%frames}}");
		$this->dropTable("{{%frames}}");
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200904_114946_add_pictures_table cannot be reverted.\n";

		return false;
	}
	*/
}
