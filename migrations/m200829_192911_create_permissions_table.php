<?php

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
			"unique_name" => $this->string(),
			"name" => $this->string(),
		]);

		$this->insert("permissions", [
			"unique_name" => "crud_users",
			"name" => "Einsehen, Erstellen, Bearbeiten und Löschen von Benutzern",
		]);
		$this->insert("permissions", [
			"unique_name" => "crud_users",
			"name" => "Einsehen, Erstellen, Bearbeiten und Löschen von Trainings",
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("permissions");
	}

}