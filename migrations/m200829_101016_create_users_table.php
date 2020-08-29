<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200829_101016_create_users_table extends Migration {

	/**
	 * {@inheritdoc}
	 * @throws \yii\base\Exception
	 */
	public function safeUp() {
		$this->createTable("users", [
			"id" => $this->primaryKey(),
			"username" => $this->string()->notNull(),
			"password_hash" => $this->string()->notNull(),
			"allow_login" => $this->boolean()->notNull()->defaultValue(0),
			"enabled" => $this->boolean()->notNull()->defaultValue(1),
		]);

		$this->insert("users", [
			"username" => "admin",
			"password_hash" => Yii::$app->security->generatePasswordHash("admin"),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("users");
	}

}
