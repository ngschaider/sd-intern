<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_events}}`.
 */
class m200829_192233_create_users_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("users_trainings", [
			"id" => $this->primaryKey(),
			"training_id" => $this->integer()->notNull(),
			"user_id" => $this->integer()->notNull(),
			"attended" => $this->boolean()->notNull()->defaultValue(1),
			"is_trainer" => $this->boolean()->notNull()->defaultValue(0),
			"created_by" => $this->integer()->notNull(),
			"created_at" => $this->dateTime()->notNull(),
			"updated_at" => $this->dateTime()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("users_trainings");
	}

}
