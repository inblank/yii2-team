<?php
/**
 * Team admin controller in the module yii2-team
 *
 * @link https://github.com/inblank/yii2-team
 * @copyright Copyright (c) 2016 Pavel Aleksandrov <inblank@yandex.ru>
 * @license http://opensource.org/licenses/MIT
 */

namespace inblank\team\controllers\backend;

use inblank\team\components\BackendController;
use inblank\team\models\Team;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends BackendController
{
    /**
     * Lists all Team models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = Yii::createObject($this->di('TeamSearch'));
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
     * @param integer $id team id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        $this->checkPermission('team_createTeam');
        /** @var Team $model */
        $model = Yii::createObject($this->di('Team'));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $emblem = Yii::$app->request->post('emblem');
            if (!empty($emblem)) {
                $model->changeEmblem($emblem);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $team = $this->findModel($id);

        $this->checkPermission('team_updateTeam', ['model' => $team]);

        if ($team->load(Yii::$app->request->post()) && $team->save()) {
            return $this->redirect(['view', 'id' => $team->id]);
        } else {
            return $this->render('update', [
                'model' => $team,
            ]);
        }
    }

    /**
     * Disband an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDisband($id)
    {
        $team = $this->findModel($id);
        $this->checkPermission('team_disbandTeam', ['model' => $team]);
        $team->disband();

        return $this->redirect(['list']);
    }

    /**
     * View team members
     * @param integer|string $id team id
     * @return mixed
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionMembers($id)
    {
        $team = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $team->getMembers(),
        ]);
        return $this->render('members', [
            'dataProvider' => $dataProvider,
            'team' => $team,
        ]);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->di('Team');
        if (($model = $modelClass::findOne(is_numeric($id) ? ['id' => $id] : ['slug' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('team_backend', 'Team not found'));
        }
    }

}
