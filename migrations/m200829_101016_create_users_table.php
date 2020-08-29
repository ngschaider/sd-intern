<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200829_101016_create_users_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("users", [
			"id" => $this->primaryKey(),
			"username" => $this->string()->notNull(),
			"password" => $this->string()->notNull(),
		]);

		$this->insert("users", [
			"username" => "admin",
			"password" => Yii::$app->security->generatePasswordHash("admin"),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function down() {
		$this->dropTable("users");
	}

}
