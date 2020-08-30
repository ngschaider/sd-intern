<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events}}`.
 */
class m200829_191012_create_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("trainings", [
			"id" => $this->primaryKey(),
			"name" => $this->string()->notNull(),
			"location_id" => $this->string()->notNull(),
			"created_by" => $this->integer()->notNull(),
			"updated_at" => $this->timestamp()->notNull(),
			"created_at" => $this->timestamp()->notNull(),
			"is_optional" => $this->boolean()->notNull(),
			"start" => $this->dateTime()->notNull(),
			"end" => $this->dateTime()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("trainings");
	}

}
