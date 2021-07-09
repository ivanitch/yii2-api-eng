<?php

namespace console\controllers;

use Yii;

class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var string
     */
    public $dumpFileName;
    public $autoFlushCache = true;
    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->autoFlushCache) {
            Yii::$app->db->getSchema()->refresh();
        }
        return parent::afterAction($action, $result);
    }
    /**
     * Creates dump of current database
     */
    public function actionDump()
    {
        $db = Yii::$app->db;
        if ($this->confirm('Are you sure you want to generate new database dump?')) {
            preg_match('/dbname=(.+)/', $db->dsn, $matches);
            //$command = 'mysqldump -d -u ' . $db->username . ' -p ' . $matches[1] . ' | sed \'s/ AUTO_INCREMENT=[0-9]*\b//\' > ' . $this->dumpFileName;
            $command = 'mysqldump -d -u ' . $db->username . ' -p ' . $matches[1] . ' > ' . $this->dumpFileName;
            exec($command);
        }
    }
}