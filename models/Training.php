<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use yii\db\ActiveRecord;

class Training extends ActiveRecord {

	public static function tableName() {
		return "trainings";
	}

	public function rules() {
		return [

		];
	}

}