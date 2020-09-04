<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\components;


use DateTime;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class ActiveRecord extends \yii\db\ActiveRecord {

	const SCENARIO_INSERT = "insert";
	const SCENARIO_UPDATE = "update";

	public static function tableName() {
		return  Yii::$app->db->tablePrefix . lcfirst(StringHelper::basename(get_called_class())) . "s";
	}

	public function __construct($config = []) {
		if($this->rulesContainScenario(self::SCENARIO_INSERT)) {
			$this->scenario = self::SCENARIO_INSERT;
		}

		parent::__construct($config);
	}

	public function afterFind() {
		if($this->rulesContainScenario(self::SCENARIO_UPDATE)) {
			$this->scenario = self::SCENARIO_UPDATE;
		}

		return parent::afterFind();
	}

	protected function rulesContainScenario($scenario) {
		foreach($this->getValidators() as $validator) {
			if($validator->on == $scenario) {
				return true;
			}
		}
		return false;
	}

}