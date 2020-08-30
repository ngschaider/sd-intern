<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%trainings}}`.
 */
class m200830_113544_add_is_optional_column_to_trainings_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn("trainings", "is_optional", $this->boolean()->notNull());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn("trainings", "is_optional");
	}

}
