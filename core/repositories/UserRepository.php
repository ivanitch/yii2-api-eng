<?php

namespace core\repositories;
use core\entities\User\User;

/**
 * Class UserRepository
 * @package core\repositories
 */
class UserRepository
{
    /**
     * @param $value
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findByUsernameOrEmail($value)
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    /**
     * @param $network
     * @param $identity
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }

    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param $token
     * @return User
     */
    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    /**
     * @param $email
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }

    /**
     * @param $token
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return User
     */
    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }
}