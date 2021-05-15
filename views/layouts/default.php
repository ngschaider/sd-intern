<?php
/**
 * @package app.views.layouts
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var string $content
 */

use yii\web\View;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;

?>


<?php $this->beginContent("@app/views/layouts/full.php"); ?>
<div class="container">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<?= Alert::widget() ?>
	<?= $content ?>
</div>
<?php $this->endContent(); ?>