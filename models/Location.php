<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Location
 *
 * @package app\models
 *
 * @property-read integer $id
 * @property string $name
 */
class Location extends ActiveRecord {

	public static function tableName() {
		return "locations";
	}

	public function rules() {
		return [
			[["name"], "required"],
			[["name"], "string", "max" => 255],
		];
	}

}