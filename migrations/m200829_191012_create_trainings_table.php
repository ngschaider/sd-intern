<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use app\components\Migration;

/**
 * Handles the creation of table `{{%trainings}}`.
 */
class m200829_191012_create_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%trainings}}", [
			"id" => $this->primaryKey(),
			"locationId" => $this->integer()->notNull(),
			"isOptional" => $this->boolean()->notNull(),
			"start" => $this->dateTime()->notNull(),
			"end" => $this->dateTime()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("{{%trainings}}");
	}

}
