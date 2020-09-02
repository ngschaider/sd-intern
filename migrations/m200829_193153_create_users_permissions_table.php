<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_permissions}}`.
 */
class m200829_193153_create_users_permissions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("userPermissions", [
			"id" => $this->primaryKey(),
			"userId" => $this->integer()->notNull(),
			"permissionId" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("userPermissions");
	}

}
