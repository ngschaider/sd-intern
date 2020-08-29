<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_permissions}}`.
 */
class m200829_193153_create_users_permissions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("users_permissions", [
			"id" => $this->primaryKey(),
			"user_id" => $this->integer()->notNull(),
			"permission_id" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("users_permissions");
	}

}
