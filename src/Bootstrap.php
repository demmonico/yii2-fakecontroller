<?php
namespace demmonico\fakecontroller;

use yii\helpers\ArrayHelper;


/**
 * Class for bootstrap FakeController
 *
 * @author: dep
 * Date: 13.01.17
 */
class Bootstrap
{
    /**
     * @var array List of fake controllers with configs from \backend\config\params.php file.
     * @example
     * fakeControllers = [
     *      ...
     *      'user' => [
     *          'modelClass' => 'backend\models\User',
     *
     *          // actions list with params
     *          // not required but if 'actions' exists then if requested action not set here - Exception
     *          // these settings will overwrite settings at self::fakeActions
     *          'actions' => [
     *              'index',
     *              'index' => 'actionClass',
     *              'update' => [
     *                  'class' => 'actionClass',
     *                  'param1' => 'value',
     *              ],
     *          ],
     *      ],
     *      ...
     * ]
     */
    private static $fakeControllers = [];

    /**
     * @var array List of fake actions.
     * @example
     * default here but can be re-init at \backend\config\params.php file:
     * fakeActions = [
     *      ...
     *      'index',                                            // for standard CRUD actions
     *      'update' => 'someActionNamespace\UpdateAction',     // for user-defined actions
     *      'create' => [                                       // for user-defined actions with additional parameters
     *          'className' => 'someActionNamespace\CreateAction',
     *          'param' => 'paramValue',
     *      ],
     *      ...
     * ]
     */
    private static $fakeActions = [

        // ordinal CRUD actions
        'index' =>  __NAMESPACE__.'\\actions\IndexAction',
        'update' => __NAMESPACE__.'\\actions\UpdateAction',
        'delete' => __NAMESPACE__.'\\actions\DeleteAction',
        'create' => __NAMESPACE__.'\\actions\UpdateAction',

        // TODO
        // yii2-config actions
//        'import-missing' => 'demmonico\config\admin\actions\ImportMissingAction',
//        'import-default' => 'demmonico\config\admin\actions\ImportDefaultAction',
    ];



    /**
     * Add fake controllers array to @app::$controllerMap
     * Use in \backend\config\main.php in "on beforeRequest" option
     */
    public static function addFakeControllers()
    {
        // if exists valid fakes
        $fakeControllers = \Yii::$app->params['fakeControllers'];
        if (!empty($fakeControllers) && is_array($fakeControllers)){
            // remember fakes
            self::$fakeControllers = $fakeControllers;
            $class = __NAMESPACE__.'\\FakeController';
            // update controller's map
            $fakeControllers = array_map(
                function() use($class) {
                    return $class;
                },
                $fakeControllers
            );
            \Yii::$app->controllerMap = array_merge($fakeControllers, \Yii::$app->controllerMap);
        }
    }

    /**
     * Returns fake controller details
     * @param $controller
     * @return bool|mixed
     */
    public static function getFakeController($controller)
    {
        if ($controller && self::$fakeControllers && array_key_exists($controller, self::$fakeControllers)){
            return self::$fakeControllers[$controller];
        } else {
            return false;
        }
    }

    /**
     * Returns fake actions list
     * @return mixed
     */
    public static function getFakeActions()
    {
        $userDefinedActions = [];
        if (isset(\Yii::$app->params['fakeActions']) && is_array(\Yii::$app->params['fakeActions']))
            $userDefinedActions = \Yii::$app->params['fakeActions'];

        return ArrayHelper::merge(self::$fakeActions, $userDefinedActions);
    }
}
