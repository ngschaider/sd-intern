<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\assets;


use yii\web\AssetBundle;

class FrameEditorAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $js = [
		"https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.1.0/fabric.min.js",
		"js/FrameEditor.js",
	];

}