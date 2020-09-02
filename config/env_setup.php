<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

/**
 * @param $name
 * @return mixed|null
 */
function env($name) {
	if(file_exists("../env.php")) {
		$values = require("../env.php");
		if(isset($values[$name])) {
			return $values[$name];
		}
	}

	return null;
}