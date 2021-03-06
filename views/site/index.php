<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div class="site-index">

    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <!--<h1 class="font-weight-light">Show & Dance Triestingtal</h1>-->
					<?= Html::img("@web/images/logo_core.png", ["class" => "img", "style" => "height: 300px; image-rendering: crisp-edges"]); ?>
                    <p class="lead">
                        <span style="padding: 5px 10px; border-radius: 5px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 1)">
                            Internal Management Platform
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="body-content" style="margin-top: 20px">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                    <h2>Homepage</h2>
                    <p>
                        Diese Applikation ist lediglich zur Verwendung durch Mitglieder bestimmt.<br>
                        Falls du aus Versehen hier gelandet bist kannst du über folgenden Button zu unserer Homepage wechseln:
                    </p>
                    <p><a class="btn btn-outline-secondary" href="https://sdtriestingtal.at/">Zu unserer Homepage &raquo;</a></p>
                </div>
            </div>
        </div>

    </div>
</div>
