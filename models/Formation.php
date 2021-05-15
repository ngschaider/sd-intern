<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;


use app\components\ActiveRecord;

class Formation extends ActiveRecord {

	public function rules() {
		return [
			[["name"], "required"],
			[["name"], "string", "max" => 255],
		];
	}

}