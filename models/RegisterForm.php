<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $passwordConfirm;
    public $main_email;
    public $backup_email;
    public $cellphone;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'passwordConfirm', 'main_email'], 'required'],
            [['cellphone'], 'string', 'max' => 16],
            ['username', 'validateUsername'],
            ['password', 'validatePassword'],
            [['main_email', 'backup_email'], 'email'],
            ['passwordConfirm', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match."],
        ];
    }

    /**
     * Validates the availability of the username.
     * 
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if (User::findByUsername($this->username)){
            $this->addError($attribute, 'Username is not available.');
        }
    }

    /**
     * Validates the strength of the password.
     * 
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        $pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';
        if(!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'Password is not strong enough.');
        }
    }

    /**
     * Registers a user.
     * @return bool whether the user was created successfully.
     */
    public function register()
    {
        $model = new User();
        if ($this->validate()) {
            $model->username     = $this->username;
            $model->password     = $this->password;
            $model->main_email   = $this->main_email;
            $model->backup_email = $this->backup_email;
            $model->cellphone    = $this->cellphone;
            $model->authKey      = $this->generate_string();
            $model->accessToken  = $this->generate_string();
            $model->is_validated = 0;
            $model->is_admin     = 0;
            $model->is_active    = 0;
            return $model->save();
        }
        return false;
    }

    private function generate_string() {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < 64; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}