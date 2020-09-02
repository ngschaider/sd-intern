<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

/**
 * @param $name
 * @return mixed|null
 */
function env($name) {
        if(file_exists(__DIR__ . "/../env.php")) {
                $values = require  __DIR__ . "/../env.php";
                if(isset($values[$name])) {
                        return $values[$name];
                }
        }

        return null;
}
