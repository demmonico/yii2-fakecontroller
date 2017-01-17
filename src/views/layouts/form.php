<?php
/**
 * @author: dep
 * Date: 01.02.16
 */

/**
 *@var $this yii\web\View
 *@var $content string
 */

$col = \yii\helpers\ArrayHelper::getValue($this->params, 'col', 4);
$this->title = $this->title ?: ucfirst($this->context->id);
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?=\yii\widgets\Breadcrumbs::widget([
            'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i>'.Yii::t('app', 'Dashboard'),'url'=>Yii::$app->homeUrl],
            'tag'=>'ol',
            'encodeLabels'=>false,
            'links' => isset($this->params['breadcrumbs'])?$this->params['breadcrumbs']:['label' => $this->title]
        ])?>
        <br>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-<?= (12 - $col) / 2?>"></div>
            <div class="col-md-<?=$col?>">
                <div class="box <?=\yii\helpers\ArrayHelper::getValue($this->params, 'boxClass', '')?>">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=isset($this->params['header'])?$this->params['header']:$this->title ?></h3>
                    </div>
                    <div class="box-body" >
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <div class="col-md-<?= (12 - $col) / 2?>"></div>
        </div>
    </section>

<?php $this->endContent(); ?>