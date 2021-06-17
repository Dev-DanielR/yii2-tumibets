<?php
 
namespace app\components;
 
use app\models\User;
class AccessRule extends \yii\filters\AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles))  return true;

        foreach ($this->roles as $role) switch ($role) {
            case '?':             return $user->getIsGuest();
            case User::ROLE_USER: return !$user->getIsGuest();
            default:              return !$user->getIsGuest() && $role == $user->identity->role;
        }
    }
}