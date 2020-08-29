<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usergroups_permissions}}`.
 */
class m200829_193204_create_usergroups_permissions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("usergroups_permissions", [
			"id" => $this->primaryKey(),
			"usergroup_id" => $this->integer()->notNull(),
			"permission_id" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("usergroups_permissions");
	}

}
