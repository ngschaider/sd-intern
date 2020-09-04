<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use app\components\Migration;

/**
 * Handles the creation of table `{{%usergroups}}`.
 */
class m200829_192458_create_usergroups_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("usergroups", [
			"id" => $this->primaryKey(),
			"name" => $this->string()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("usergroups");
	}

}
