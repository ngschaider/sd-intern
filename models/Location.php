<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use yii\db\ActiveRecord;

class Location extends ActiveRecord {

	public static function tableName() {
		return "locations";
	}

	public function rules() {
		return [

		];
	}

}