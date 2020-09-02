<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Class m200901_183652_add_foreign_keys
 */
class m200901_183652_add_foreign_keys extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addForeignKey("fk-trainings-locationId", "trainings", "locationId", "locations", "id");

		$this->addForeignKey("fk-userTrainings-trainingId", "userTrainings", "trainingId", "trainings", "id", "CASCADE");
		$this->addForeignKey("fk-userTrainings-userId", "userTrainings", "userId", "users", "id");

		$this->addForeignKey("fk-userPermissions-userId", "userPermissions", "userId", "users", "id", "CASCADE");
		$this->addForeignKey("fk-userPermissions-permissionId", "userPermissions", "permissionId", "users", "id", "CASCADE");

		$this->addForeignKey("fk-usergroupPermissions-usergroupId", "usergroupPermissions", "usergroupId", "usergroups", "id", "CASCADE");
		$this->addForeignKey("fk-usergroupPermissions-permissionId", "usergroupPermissions", "permissionId", "usergroups", "id", "CASCADE");

		$this->addForeignKey("fk-userUsergroups-usergroupId", "userUsergroups", "usergroupId", "usergroups", "id", "CASCADE");
		$this->addForeignKey("fk-userUsergroups-userId", "userUsergroups", "userId", "users", "id", "CASCADE");
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		echo "m200901_183652_add_foreign_keys cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200901_183652_add_foreign_keys cannot be reverted.\n";

		return false;
	}
	*/
}
