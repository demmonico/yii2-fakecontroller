<?php
namespace demmonico\fakecontroller\actions;

use yii\web\ServerErrorHttpException;


/**
 * Action allows view list of models.
 */
class IndexAction extends Action
{
    /**
     * Name of method which realize search strategy
     * @var string
     */
    public $searchMethod = 'search';

    /**
     * @inheritance
     */
    protected $layoutDefault = 'grid';



    public function run()
    {
        // set search scenario if possible
        $searchScenarioName = $this->modelClass.'::SCENARIO_SEARCH';
        if(defined($searchScenarioName) && array_key_exists(constant($searchScenarioName), $this->model->scenarios()))
            $this->model->setScenario(constant($searchScenarioName));

        // check for search method
        if (!method_exists($this->model, $this->searchMethod))
            throw new ServerErrorHttpException('Invalid model. Search method not realized');

        // create dataProvider by calling model search method
        $dataProvider = call_user_func_array([$this->model, $this->searchMethod], [\Yii::$app->request->getQueryParams()]);

        return $this->controller->render($this->viewName, ['model' => $this->model, 'dataProvider' => $dataProvider]);
    }
}