<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use app\components\Migration;

/**
 * Handles the creation of table `{{%userTrainings}}`.
 */
class m200829_192233_create_userTrainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%userTrainings}}", [
			"id" => $this->primaryKey(),
			"trainingId" => $this->integer()->notNull(),
			"userId" => $this->integer()->notNull(),
			"attended" => $this->boolean()->notNull()->defaultValue(1),
			"isTrainer" => $this->boolean()->notNull()->defaultValue(0),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("{{%userTrainings}}");
	}

}
