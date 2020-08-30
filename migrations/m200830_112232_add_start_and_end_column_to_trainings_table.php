<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%trainings}}`.
 */
class m200830_112232_add_start_and_end_column_to_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn("trainings", "start", $this->dateTime()->notNull());
		$this->addColumn("trainings", "end", $this->dateTime()->notNull());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn("trainings", "end");
		$this->dropColumn("trainings", "start");
	}

}
