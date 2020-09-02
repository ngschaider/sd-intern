<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_usergroups}}`.
 */
class m200831_191120_create_users_usergroups_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("userUsergroups", [
			"id" => $this->primaryKey(),
			"usergroupId" => $this->integer()->notNull(),
			"userId" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("userUsergroups");
	}

}
