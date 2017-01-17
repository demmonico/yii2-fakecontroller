<?php
/**
 * @author: dep
 * Date: 27.01.16
 *
 * @var $this yii\web\View
 * @var $model backend\models\User
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $frontendUrlManager yii\web\UrlManager
 */


$this->params['model'] = $model;
$this->params['dataProvider'] = $dataProvider;

$this->params['toolbar'] = [
    /*'content'=> \yii\bootstrap\Html::tag('form',
                                 \yii\bootstrap\Html::a('New position',['create'],['class' => 'btn btn-success', 'data-pjax'=>0]),
                                 ['onChange'=>'this.submit();','class'=>'form-inline'])*/
];


//$statusArr = $model->getStatus();
//$roleArr = $model->getRole();
//$boolArr = $model->getBool();

$this->params['columns']  = [
//    \backend\helpers\FormatHelper::getGridColumn('id'),
//    \backend\helpers\FormatHelper::getGridColumn('email', null, 'string'),
//    [
//        'attribute' => 'email_is_confirmed',
//        'label' => 'Email confirmed',
//        'value' => function( $model, $index, $widget ) use ($boolArr) { return $boolArr[$model->email_is_confirmed]; },
//        'hAlign'=>'center',
//        'filter' => $boolArr,
//        'filterOptions' => ['class' => 'col-xs-1'],
//    ],
//    \backend\helpers\FormatHelper::getGridColumn('username', null, 'string'),
//    [
//        'attribute' => 'role',
//        'value' => function( $model, $index, $widget ) use ($roleArr) { return $roleArr[$model->role]; },
//        'hAlign'=>'center',
//        'filter' => $roleArr,
//        'filterOptions' => ['class' => 'col-xs-1'],
//    ],
//    [
//        'attribute' => 'status',
//        'value' => function( $model, $index, $widget ) use ($statusArr) { return $statusArr[$model->status]; },
//        'hAlign'=>'center',
//        'filter' => $statusArr,
//        'filterOptions' => ['class' => 'col-xs-1'],
//    ],
//    \backend\helpers\FormatHelper::getGridColumn('created'),
//    \backend\helpers\FormatHelper::getGridColumn('updated', null, 'created'),


    /*[
        'class' => 'yii\grid\ActionColumn',
        'template'=>'{update} {delete}',
        'buttons'=>[
            'update' => function ($url, $model, $key) {
                if($model->role !== \backend\models\User::ROLE_ROOT)
                    return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url) ;
                else
                    return '';
            },
            'delete' => function ($url, $model, $key) {
                if($model->role !== \backend\models\User::ROLE_ROOT)
                    //return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash grid-btn-delete"></span>', $url) ;
                    return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                        'data-id'   => $model->id,
                        'class'     => 'grid-btn-delete',
                    ]) ;
                else
                    return '';
            },
        ],
    ],*/

    [
        'class' => 'yii\grid\ActionColumn',
        'template'=>'{update} {delete}',
        'buttons'=>[
            'update' => function ($url, $model, $key) {
                if($model->role !== \backend\models\User::ROLE_ROOT)
                    return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url) ;
                else
                    return '';
            },
            'delete' => function ($url, $model, $key) {
                if($model->role !== \backend\models\User::ROLE_ROOT)
                    //return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash grid-btn-delete"></span>', $url) ;
                    return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                        'data-id'   => $model->id,
                        'class'     => 'grid-btn-delete',
                    ]) ;
                else
                    return '';
            },
        ],
    ],

    /*'title'=>[
        'attribute'=>'title',
        'format' => 'raw',
        'value'=> function ($model, $index, $widget) {
            if ($model->getContent('title_id')){
                $model->title = strip_tags($model->getContent('title_id'));
                return (strlen($model->title) > 100) ? substr($model->title, 0, 100) : $model->title;
            } else{
                return  Yii::t('app','No translation');
            }
        },
        'filter' => '<input type="text" class="form-control" name="Job[title]" value="'. (isset($_GET['Job']['title'])?$_GET['Job']['title']:'') .'"/>',
        'filterOptions' => [
            'class' => 'col-xs-2'
        ],
    ],

    'location'=>[
        'attribute'=>'location',
        'format' => 'raw',
        'value'=> function ($model, $index, $widget) {
            if ($model->getContent('location_id')){
                $model->location = strip_tags($model->getContent('location_id'));
                return (strlen($model->location) > 100) ? substr($model->location, 0, 100) : $model->location;
            } else{
                return  Yii::t('app','No translation');
            }
        },
        'filter' => '<input type="text" class="form-control" name="Job[location]" value="'. (isset($_GET['Job']['location'])?$_GET['Job']['location']:'') .'"/>',
        'filterOptions' => [
            'class' => 'col-xs-2'
        ],
    ],
    'description'=>[
        'attribute'=>'description',
        'format' => 'raw',
        'value'=> function ($model, $index, $widget) {
            if ($model->getContent('description_id')){
                $model->description = strip_tags($model->getContent('description_id'));
                return (strlen($model->description) > 100) ? substr($model->description, 0, 100) : $model->description;
            } else{
                return  Yii::t('app','No translation');
            }
        },
        'filter' => '<input type="text" class="form-control" name="Job[description]" value="'. (isset($_GET['Job']['description'])?$_GET['Job']['description']:'') .'"/>',
    ],*/
];
