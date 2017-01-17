<?php
namespace demmonico\fakecontroller\actions;

use yii\db\ActiveRecord;
use yii\rest\Action as BaseAction;
use yii\web\ServerErrorHttpException;


/**
 * List of models.
 */
abstract class Action extends BaseAction
{
    /**
     * @var string Custom view path for action. Can be overwritten
     * @default __NAMESPACE__.'../views/'
     */
    public $viewPath;
    /**
     * @var string Custom view name for action. Can be overwritten
     * @default $this->id
     */
    public $viewName;

    /**
     * @var string Custom layout for action. Can be overwritten
     * @example
     * "fakeDefault" - use layout from component path
     * null - use default path e.g. @app\views\layouts\main
     */
    public $layout = 'fakeDefault';
    /**
     * @var string Default layout for action. Should be overwritten at inheritances
     */
    protected $layoutDefault;

    /**
     * @var ActiveRecord $modelClass
     */
    protected $model;



    /**
     * Overwrites parent
     * @throws ServerErrorHttpException
     */
    public function init()
    {
        $currentController = $this->controller;

        // set model
        if (empty($this->modelClass)){
            if (isset($currentController->modelClass) && !empty($currentController->modelClass))
                $this->modelClass = $currentController->modelClass;
            else
                throw new ServerErrorHttpException('Invalid model class');
        }
        $this->model = \Yii::createObject($this->modelClass);
        if (!$this->model instanceof ActiveRecord)
            throw new ServerErrorHttpException('Invalid model instance');

        // set layout
        if (empty($this->layoutDefault))
            throw new ServerErrorHttpException('Invalid default layout path');
        if ($this->layout === 'fakeDefault'){
            \Yii::$app->setAliases(['@fakecontroller' => dirname(__DIR__)]);
            $this->layout = '@fakecontroller/views/layouts/'.$this->layoutDefault;
        }
        if (!empty($this->layout))
            $currentController->layout = $this->layout;

        // set view path
        $currentController->setViewPath($this->viewPath ?: (dirname(__DIR__).'/views'));

        // set view name
        if (empty($this->viewName))
            $this->viewName = $this->id;
    }

}