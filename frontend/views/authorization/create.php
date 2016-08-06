<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Authorization */

$this->title = 'Create Authorization';
$this->params['breadcrumbs'][] = ['label' => 'Authorizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authorization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
