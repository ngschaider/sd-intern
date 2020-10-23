<?php

use yii\db\Migration;

/**
 * Class m201023_115825_remove_isOptional_column_from_trainings_table
 */
class m201023_115825_remove_isOptional_column_from_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->dropColumn("{{%trainings}}", "isOptional");
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->addColumn("{{%trainings}}", "isOptional", $this->boolean()->notNull());
	}

}
