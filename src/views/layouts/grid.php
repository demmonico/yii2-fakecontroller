<?php
/**
 * @author: dep
 * Date: 27.01.16
 *
 * @var $this yii\web\View
 * @var $content string
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


$col = ArrayHelper::getValue($this->params, 'col', 12);
$columns = ArrayHelper::getValue($this->params, 'columns');

/* @var demmonico\fakecontroller\FakeController $controller */
$controller = $this->context;
$this->title = $this->title ?: (ucfirst($controller->id).(('s'!==substr($controller->id, -1))?'s':''));


$gridViewParams = [];
if($columns && isset($this->params['dataProvider'])){
    $gridViewParams = [
        'dataProvider' => $this->params['dataProvider'],
        'toolbar' => ArrayHelper::getValue($this->params, 'toolbar'),
        'columns' => $columns,
        'tableOptions' => [
            'class'=>'table table-hover'
        ],
        'rowOptions' => ArrayHelper::getValue($this->params, 'rowOptions'),
        'options' => [
            'class'=>'table-responsive no-padding',
            'id'=>'list'
        ],
        'summaryOptions' => [
            'class' => 'summary',
            'align' => 'center'
        ],
        'layout' => "{toolbar}\n{summary}\n{items}\n{pager}",
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => ['id' => 'pjax_container'],
        ],
        'export' => false,
    ];
    if ($model = ArrayHelper::getValue($this->params, 'model')){
        $gridViewParams = ArrayHelper::merge($gridViewParams, [
            'filterModel' => $model,
            'filterUrl' => ArrayHelper::getValue($this->params, 'filterUrl'),
        ]);
    }
}

// add JS for delete column
if ($lastColumn = array_pop($columns)){
    if (isset($lastColumn['template']) && false!==strpos($lastColumn['template'], 'delete')){
        $this->registerJsFile($controller->getAssetsUrl('js/grid-common.js'), ['depends' => 'backend\assets\AppAsset']);
    }
}
?>



<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?=$this->title?></h1>
        <?=Breadcrumbs::widget([
                                  'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i> Dashboard','url'=>Yii::$app->homeUrl],
                                  'tag'=>'ol',
                                  'encodeLabels'=>false,
                                  'links' => isset($this->params['breadcrumbs'])?$this->params['breadcrumbs']:['label' => $this->title]
                              ])?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-<?=(12 - $col) / 2?>"></div>
            <div class="col-xs-<?=$col?>">
                <div class="box">

                    <div class="box-header">
                        <?php if (isset($this->params['header'])): ?>
                            <h3 class="box-title"><?=$this->params['header']?></h3>
                        <?php endif; ?>
                        <?php if (!isset($this->params['per-page']) || $this->params['per-page'] === true): ?>
                            <div class="box-tools">
                                <form id="per-page-form" data-pjax="#pjax_container"
                                      action="<?=Url::current(['per-page' => null])?>"
                                      data-url-delete="<?=Url::to(['delete'])?>"
                                      class="input-group input-group-sm" style="width: 150px;">
                                    <?=Html::dropDownList('per-page', Yii::$app->request->get('per-page', 20),
                                                                        [10 => 10, 20 => 20, 50 => 50, 100 => 100, 200 => 200, 500 => 500],
                                                                        [
                                                                            'class' => 'form-control pull-right',
                                                                            'prompt' => 'Show entries',
                                                                        ])?>
                                </form>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="box-body" >
                        <?php
                            echo $content;
//                            if ($gridViewParams) echo \kartik\grid\GridView::widget($gridViewParams);
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-xs-<?=(12 - $col) / 2?>"></div>
        </div>
    </section>

<?php $this->endContent(); ?>






