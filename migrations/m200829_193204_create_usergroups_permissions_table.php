<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usergroups_permissions}}`.
 */
class m200829_193204_create_usergroups_permissions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("usergroupPermissions", [
			"id" => $this->primaryKey(),
			"usergroupId" => $this->integer()->notNull(),
			"permissionId" => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("usergroupPermissions");
	}

}
