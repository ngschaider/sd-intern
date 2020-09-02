<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_events}}`.
 */
class m200829_192233_create_users_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("userTrainings", [
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
		$this->dropTable("userTrainings");
	}

}
