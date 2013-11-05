<?php

class ProcessController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('run'),
                'roles' => array('guest'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('view', 'create', 'update', 'admin'),
                'roles' => array('user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
                'roles' => array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['progress'])) {

                $process = Process::model()->findByPk($id);
                $result = array(
                    'state' => Process::getStateProcess($process),
                    'status' => Process::getLabelStatus($process->status));
                $result = json_encode($result);
                echo $result;
                Yii::app()->end();
            }
        }

        $model = new CActiveDataProvider('Process', array(
            'criteria' => array(
                'condition' => 'id=' . $id)));

        $this->render('view', array(
            'model' => $model,
            'id' => $id
        ));
    }

    public function getStatusProcess($id) {
        $process = Process::model()->findByPk($id);
        return (!is_null($process)) ? $process->status : NULL;
    }

    public function stopProcess($id) {
        $process = Process::model()->findByPk($id);
        $process->status = Process::STOP; //установили статус
        $process->save();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Process;

        if (isset($_POST['Process'])) {
            $model->attributes = $_POST['Process'];

            $model->iduser = Yii::app()->user->id;

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Process'])) {
            $model->attributes = $_POST['Process'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionRun($id) {
        $process = Process::model()->findByPk($id);
        $process->status = Process::RUN; //установили статус
        $process->timestart = time(); //указали время запуска процесса
        $process->save();


        while (($process->timeexec > (time() - $process->timestart)) && ($process->status == Process::RUN)) {
            var_dump(time());
            sleep(1);
            $process->status = self::getStatusProcess($id);
        }
        if ($process->status != Process::STOP) {
            $process->status = Process::DONE; //установили статус
        }

        $process->save();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (!isset($_GET['userId'])) {
            $userId = Yii::app()->user->id;
        } else {
            $userId = $_GET['userId'];
        }


        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['run'])) {
                $fp = fsockopen($_SERVER['HTTP_HOST'], 80, $errno, $errstr, 30);
                $vars = array(
                    'userId' => $userId
                );
                $content = http_build_query($vars, '', '&');
                fwrite($fp, "GET " . Yii::app()->createUrl('process/run', array('id' => $_GET['id'])) . " HTTP/1.1\r\n");
                fwrite($fp, "Host: {$_SERVER['HTTP_HOST']} \r\n");
                fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
                fwrite($fp, "Content-Length: " . strlen($content) . "\r\n");
                fwrite($fp, "Connection: close\r\n");
                fwrite($fp, "\r\n");
                fwrite($fp, $content);
                header('Content-type: text/html');

                Yii::app()->end();
            }

            if (isset($_GET['stop'])) {
                $this->stopProcess($_GET['id']);
                Yii::app()->end();
            }
        }

        $model = new CActiveDataProvider('Process', array(
            'criteria' => array(
                'condition' => 'iduser=' . $userId)));

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Process the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Process::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Process $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'process-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
