<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use app\components\Migration;

/**
 * Handles the creation of table `{{%userUsergroups}}`.
 */
class m200831_191120_create_userUsergroups_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%userUsergroups}}", [
			"id" => $this->primaryKey(),
			"usergroupId" => $this->integer()->notNull(),
			"userId" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("{{%userUsergroups}}");
	}

}
