<?php
namespace common\fixtures;

use api\core\entities\User\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}