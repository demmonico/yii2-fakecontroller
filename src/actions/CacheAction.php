<?php
namespace demmonico\fakecontroller\actions;


/**
 * Action allows clearing up yii app cache.
 */
class CacheAction extends Action
{
    /**
     * @var string
     */
    public $layout = 'grid';

    /**
     * @var array list of available mode with related cache components
     */
    public $modeList = [
        'all'       => ['cache', 'cacheFrontend'],
        'frontend'  => 'cacheFrontend',
        'backend'   => 'cache',
    ];



    public function run()
    {
        $mode = \Yii::$app->request->get('mode');
        if (isset($this->modeList[$mode])){

            // get list of cache components that should be cleared
            $components = is_array($this->modeList[$mode]) ? $this->modeList[$mode] : [$this->modeList[$mode]];

            $isError = false;
            foreach ($components as $i){
                $isError = !isset(\Yii::$app->{$i}) || !\Yii::$app->{$i}->flush();
                if ($isError){
                    break;
                }
            }

            if (!$isError)
                \Yii::$app->getSession()->setFlash('success', ucfirst($mode).' cache was cleared successfully');
            else
                \Yii::$app->getSession()->setFlash('error', 'Some error happened while clearing '.$mode.' cache');
        } else {
            \Yii::$app->getSession()->setFlash('error', 'Invalid mode');
        }

        return $this->controller->render($this->id);
    }

}