<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\components;


use DateTime;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord {

	public function behaviors() {
		return [
			"timestamp" => [
				"class" => TimestampBehavior::class,
				"value" => function($event) {
					return (new DateTime())->format("Y-m-d H:i:s");
				}
			],
			"blameable" => [
				"class" => BlameableBehavior::class,
				"updatedByAttribute" => false,
			],
		];
	}

}