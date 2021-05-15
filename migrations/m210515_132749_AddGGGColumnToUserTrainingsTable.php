<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_trainings}}`.
 */
class m210515_132749_AddGGGColumnToUserTrainingsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%userTrainings}}", "ggg", $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("{{%userTrainings}}", "ggg");
    }
}
