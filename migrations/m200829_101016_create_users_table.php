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
			"firstname" => $this->string()->null(),
			"lastname" => $this->string()->null(),
			"password_hash" => $this->string()->notNull(),
			"allow_login" => $this->boolean()->notNull()->defaultValue(0),
			"enabled" => $this->boolean()->notNull()->defaultValue(1),
			"created_by" => $this->integer()->notNull(),
			"created_at" => $this->datetime()->notNull(),
			"updated_at" => $this->datetime()->notNull(),
		]);

		$this->insert("users", [
			"id" => 1,
			"username" => "admin",
			"password_hash" => Yii::$app->security->generatePasswordHash("admin"),
			"allow_login" => 1,
			"enabled" => 1,
			"created_by" => 1,
			"created_at" => (new DateTime())->format("Y-m-d H:i:s"),
			"updated_at" => (new DateTime())->format("Y-m-d H:i:s"),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("users");
	}

}
