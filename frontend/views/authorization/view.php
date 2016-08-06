<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Authorization */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Authorizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authorization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => (string)$model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => (string)$model->_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            'email',
            'access_token',
            'refresh_token',
            'expire_at',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
