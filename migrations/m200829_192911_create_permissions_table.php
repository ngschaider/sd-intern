<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permissions}}`.
 */
class m200829_192911_create_permissions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("permissions", [
			"id" => $this->primaryKey(),
			"name" => $this->string()->notNull(),
			"description" => $this->string()->null(),
		]);

		$this->insert("permissions", [
			"name" => "crud_users",
			"description" => "Einsehen, Erstellen, Bearbeiten und Löschen von Benutzern",
		]);
		$this->insert("permissions", [
			"name" => "crud_trainings",
			"description" => "Einsehen, Erstellen, Bearbeiten und Löschen von Trainings",
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("permissions");
	}

}