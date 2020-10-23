<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%trainings}}`.
 */
class m201023_101351_add_maxUsers_column_to_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn("{{%trainings}}", "maxUsers", $this->integer()->notNull()->defaultValue(12));
		$this->update("{{%trainings}}", ["maxUsers" => -1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn("{{%trainings}}", "maxUsers");
	}

}
