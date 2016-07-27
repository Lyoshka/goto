<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class IndexForm extends Model
{
    public $username;
    public $password;
    public $codeSMS;
    public $text;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Необходимо указать номер телефона'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 16, 'max' => 16],


            ['codeSMS', 'required', 'message' => 'Необходимо ввести КОД из СМС'],
//            ['codeSMS', 'string', 'min' => 4, 'max' => 4],
            // password is validated by validatePassword()
            ['codeSMS', 'validateCodeSMS'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            //return null;
        }

        if ($this->getUser() === null) {

			$this->codeSMS = rand(1000,9999);

            Yii::$app->session->setFlash('error', 'SMS code: ' . $this->codeSMS);
        
            $user = new User();
            $user->username = $this->username;
            $user->codeSMS = $this->codeSMS;
            $user->email = preg_replace("/[^0-9]/", '', $this->username);
            $user->setPassword($this->codeSMS);
            $user->generateAuthKey();
            $user->text = $this->text;
        
            return $user->save() ? $user : null;

		}  else {
			
			$this->getUser();
			//Yii::$app->session->setFlash('success', 'SMS code: ' . $this->codeSMS);
	        $this->login();
			
        }
    }


    /**
     * Validates the codeSMS.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateCodeSMS($attribute, $params)
    {

        if ($this->codeSMS !== null) {

        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->codeSMS)) {
                $this->addError($attribute, 'Веден не правильный код СМС');
            }
        }
      } else {

	}

    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
			return Yii::$app->user->login($this->getUser());
            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }


}
