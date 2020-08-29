<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <!--<h1 class="font-weight-light">Show & Dance Triestingtal</h1>-->
					<?= Html::img("@web/images/logo-512.png", ["class" => "img", "style" => "height: 300px"]); ?>
                    <p class="lead">
                        <span style="padding: 5px 10px; border-radius: 5px; text-shadow: 0 0 15px rgba(0, 0, 0, 0.75)">
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
                <div class="col-lg-4">
                    <h2>Homepage</h2>
                    <p>
                        Diese Applikation ist lediglich zur Verwendung durch Mitglieder bestimmt.<br>
                        Falls du aus Versehen hier gelandet bist kannst du über folgenden Button zu unserer Homepage wechseln:
                    </p>
                    <p><a class="btn btn-outline-secondary" href="https://sdtriestingtal.at/">Zu unserer Homepage &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heading</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heading</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
                </div>
            </div>
        </div>

    </div>
</div>
