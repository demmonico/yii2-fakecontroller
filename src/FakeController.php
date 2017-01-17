<?php
namespace demmonico\fakecontroller;

use demmonico\helpers\RequestHelper;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


/**
 * Class FakeController for create fake controllers
 *
 * @author: dep
 * Date: 13.01.17
 */
class FakeController extends Controller
{
    /**
     * @var object The name of current model at controller. Must be defined.
     */
    public $modelClass;

    /**
     * @var array List of actions which are enabled by default
     */
    public $actionsDefault = ['index', 'create', 'update', 'delete'];

    /**
     * @var array List of fake controllers with configs from \backend\config\params.php file.
     */
    private $fakeActions = [];

    /**
     * @var array current fake controller's config
     */
    private $fakeConfig;

    /**
     * @var string Url to published assets
     */
    private $_assetsUrl;



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), $this->fakeActions);
    }

    /**
     * @inheritdoc
     * @throws ForbiddenHttpException
     */
    public function init()
    {
        parent::init();

        // fake controllers
        if (false !== $controllerConfig=Bootstrap::getFakeController($this->id)) {

            // set modelClass
            if (isset($controllerConfig['modelClass']) && !empty($controllerConfig['modelClass']))
                $this->modelClass = $controllerConfig['modelClass'];

            // get request or default action
            if (false === $action = RequestHelper::getRequestAction())
                $action = $this->defaultAction;

            // prepare actions list
            $fakeActions = Bootstrap::getFakeActions();
            if (!isset($controllerConfig['actions']) || !is_array($controllerConfig['actions']))
                $controllerConfig['actions'] = $this->actionsDefault;

            // apply user-defined actions
            foreach ($controllerConfig['actions'] as $k => $v){
                // apply actions config if name is set only
                if (is_int($k)){
                    if (!empty($v) && isset($fakeActions[$v]) && !empty($fakeActions[$v])){
                        $controllerConfig['actions'][$v] = $fakeActions[$v];
                        unset($controllerConfig['actions'][$k]);
                    } else {
                        throw new NotFoundHttpException();
                    }
                }
                // merge action config custom with common
                else if (isset($fakeActions[$k]) && !empty($fakeActions[$k]) && is_array($fakeActions[$k])){
                    $controllerConfig['actions'][$k] = ArrayHelper::merge($fakeActions[$k], $controllerConfig['actions'][$k]);
                }
            }

            // check access for this action
            if (array_key_exists($action, $controllerConfig['actions'])) {
                $this->fakeActions[$action] = $controllerConfig['actions'][$action];
            } else {
                throw new ForbiddenHttpException();
            }

            // remember fake controller's data
            $this->fakeConfig = $controllerConfig;
        }
    }

    /**
     * Returns url to passed assets
     * @param null|string $assetName
     * @return string
     */
    public function getAssetsUrl($assetName=null)
    {
        $this->publishAssets();

        if (is_null($assetName))
            return $this->_assetsUrl;

        return $this->_assetsUrl.'/'.trim($assetName, '/');
    }

    /**
     * Publish passed assets
     */
    private function publishAssets()
    {
        if (is_null($this->_assetsUrl)){
            $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
            $assets = \Yii::$app->assetManager;
            $assets->publish($dir);
            $this->_assetsUrl = $assets->getPublishedUrl($dir);
        }
    }

}
