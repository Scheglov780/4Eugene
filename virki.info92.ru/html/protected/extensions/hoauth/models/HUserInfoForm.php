<?php

/**
 * HUserInfoForm used to collect username and email, when provider doesn't give it.
 * When user provides existing email, then model will ask for password and when it will be correct,
 * then user can link curren provider to the local account.
 * @uses      CFormModel
 * @version   1.2.5
 * @copyright Copyright &copy; 2013 Sviatoslav Danylenko
 * @author    Sviatoslav Danylenko <dev@udf.su>
 * @license   MIT ({@link http://opensource.org/licenses/MIT})
 * @link      https://github.com/SleepWalker/hoauth
 */
class HUserInfoForm extends CFormModel
{
    /**
     * Scenario is required for this model, and also we need info about model, that we will be validating
     * @access public
     */
    public function __construct($model, $emailAtt, $nameAtt = null, $scenario = 'both')
    {
        if (empty($emailAtt)) {
            throw new CException('$emailAtt can not be empty! Please specify email attribute name.');
        }

        $this->email = $model->$emailAtt;

        if (empty($nameAtt)) {
            $scenario = 'email';
        } else {
            $this->username = $model->$nameAtt;
        }

        // correcting scenarios, if some of fields is not empty
        if ($this->scenario == 'both') {
            if (!empty($this->email)) {
                $this->scenario = 'username';
            }
            if (!empty($this->username)) {
                $this->scenario = 'email';
            }
        }

        $this->nameAtt = $nameAtt;
        $this->emailAtt = $emailAtt;
        $this->_model = $model;

        parent::__construct($scenario);
    }

    protected $_form = false;
    /**
     * @var CActiveRecord $model the model of the User
     */
    protected $_model;
    /**
     * @var $email
     */
    public $email;
    /**
     * @var string $emailAtt name of the username attribute from $model
     */
    public $emailAtt;
    /**
     * @var string $nameAtt name of the username attribute from $model
     */
    public $nameAtt;
    /**
     * @var $password
     */
    public $password;
    /**
     * @var $username
     */
    public $username;

    /**
     * Switch to the password scenario, when we dealing with passwords
     */
    public function afterConstruct()
    {
        parent::afterConstruct();
        if (isset($_POST) && !empty($_POST[__CLASS__]['password'])) {
            $this->scenario .= '_pass';
        }
    }

    public function attributeLabels()
    {
        return [
          'email'    => $this->_model->getAttributeLabel($this->emailAtt),
          'username' => $this->_model->getAttributeLabel($this->nameAtt),
          'password' => HOAuthAction::t('Password'),
        ];
    }

    /**
     * @return error string for account confirmation
     */
    public function confirmStr($attributeName)
    {
        return HOAuthAction::t(
          "This {attribute} is taken by another user. If this is your account, enter password in field below or change {attribute} and leave password blank.",
          ['{attribute}' => $this->getAttributeLabel($attributeName)]
        );
    }

    /**
     * @access public
     * @return CForm instance
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new CForm([
              'id'         => strtolower(__CLASS__),
              'elements'   => [
                '<div class="form">',
                $this->header,
                'username' => [
                  'type' => 'text',
                ],
                'email'    => [
                  'type' => 'text',
                ],
                'password' => [
                  'type' => 'password',
                ],
              ],
              'buttons'    => [
                'submit' => [
                  'type'  => 'submit',
                  'label' => HOAuthAction::t('Submit'),
                ],
                '</div>',
              ],
              'activeForm' => [
                'id'                     => strtolower(__CLASS__) . '-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => true,
                'clientOptions'          => [
                  'validateOnSubmit' => true,
                  'validateOnChange' => true,
                ],
              ],
            ], $this);
        }
        return $this->_form;
    }

    /**
     * Different form headers for different scenarios
     * @access public
     * @return void
     */
    public function getHeader()
    {
        $header = '';
        switch ($this->scenario) {
            case 'both':
                $header =
                  HOAuthAction::t(
                    'Please specify your ' .
                    $this->getAttributeLabel('username') .
                    ' and ' .
                    $this->getAttributeLabel('email') .
                    ' to end with registration.'
                  );
                break;
            case 'username':
                $header =
                  HOAuthAction::t(
                    'Please specify your ' . $this->getAttributeLabel('username') . ' to end with registration.'
                  );
                break;
            case 'email':
                $header =
                  HOAuthAction::t(
                    'Please specify your ' . $this->getAttributeLabel('email') . ' to end with registration.'
                  );
                break;
        }

        return "<p class=\"hFormHeader\">$header</p>";
    }

    /**
     * Validate shortcut for CForm class instance
     */
    public function getIsFormValid()
    {
        if ($this->form->submitted('submit')) {
            return $this->form->validate();
        }

        // account confiramtion scenario, when social network
        // returned email of existing local account
        if (!$this->_model->isNewRecord) {
            $this->addError('email', $this->confirmStr('email'));
            $this->scenario = 'email_pass';
            return false;
        }
        return $this->validate();
    }

    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Transfers collected values to the {@link HUserInfoForm::model}
     * @access public
     * @return void
     */
    public function getValidUserModel()
    {
        if ($this->hasErrors()) {
            return null;
        }

        // syncing only when we have a new model
        if ($this->_model->isNewRecord && strpos($this->scenario, '_pass') === false) {
            $this->_model->setAttributes([
              $this->emailAtt => $this->email,
              $this->nameAtt  => $this->username,
            ], false);

            if (HOAuthAction::$useYiiUser) {
                $this->_model->superuser = 0;
                $this->_model->status =
                  (Yii::app()->getModule('user')->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE;
                $this->_model->activkey = UserModule::encrypting(microtime() . $this->_model->email);
            }
        }

        return $this->model;
    }

    public function rules()
    {
        return [
          ['username', 'required', 'on' => 'username, both'], //, username_pass, both, both_pass'),
          ['email', 'required', 'on' => 'email, email_pass, both, both_pass, username_pass'],
          [
            'email',
            'email',
            'allowEmpty' => true,
            'allowName'  => false,
            'pattern'    => '/[a-z0-9\-\.\+%_]+@[a-z0-9\.\-]+\.[a-z]{2,6}/i',
          ],
          ['password', 'required', 'on' => 'email_pass, username_pass, both_pass'],
          ['password', 'validatePassword', 'on' => 'email_pass, username_pass, both_pass'],
          ['password', 'unsafe', 'on' => 'email, username, both'],
        ];
    }

    /**
     * Validates password, when password is correct, then sets the
     * {@link HUserInfoForm::model} variable to new User model
     * @access public
     * @return void
     */
    public function validatePassword($attribute, $params)
    {
        if (HOAuthAction::$useYiiUser) {
            $user = User::model()->notsafe()->findByAttributes(['email' => $this->email]);
            $valid = Yii::app()->getModule('user')->encrypting($this->password) === $user->password;
        } else {
            $user = $this->_model->findByEmail($this->email);
            if (method_exists($this->_model, 'verifyPassword')) {
                $valid = $user->verifyPassword($this->$attribute);
            } elseif (method_exists($this->_model, 'validatePassword')) {
                $valid = $user->validatePassword($this->$attribute);
            } else {
                throw new CException(
                  'You need to implement verifyPassword($password) or validatePassword($password) method in order to let hoauth validate user password.'
                );
            }
        }

        if ($valid) // setting up the current model, to use it later in HOAuthAction
        {
            $this->_model = $user;
        } else {
            $this->addError('password', HOAuthAction::t('Sorry, but password is incorrect'));
        }
    }

    /**
     * The main function of this class. Here we validating user input with
     * provided {@link HUserInfoForm::model} class instance. We also trying
     * to catch the case, when user enters email or username of existing account.
     * In this case HUserInfoForm will be switched to `_pass` scenarios.
     * @access public
     * @return boolean true if the user input is valid for both {@link HUserInfoForm::model} and HUserInfoForm models
     */
    public function validateUser()
    {
        if (!$this->isFormValid) {
            return false;
        }

        // beginning from valid models, without any errors
        $this->clearErrors();
        $this->_model->clearErrors();

        $user = $this->_model;
        $emailAtt = $this->emailAtt;
        $nameAtt = $this->nameAtt;

        $validators = [];

        // initilizing properties of user model
        if ($nameAtt) {
            $user->$nameAtt = $this->username;
            $attributes[] = $nameAtt;
            $validators = $user->getValidators($nameAtt);
        }
        if ($emailAtt) {
            $user->$emailAtt = $this->email;
            $attributes[] = $emailAtt;
            foreach ($user->getValidators($emailAtt) as $validator)
                // it can be, that one validator is used for both atts
            {
                if (!in_array($validator, $validators, true)) {
                    $validators[] = $validator;
                }
            }
        }

        $ignored = [];
        foreach ($validators as $validator) {
            foreach ($attributes as $attribute) {
                // we need to determine if we have a new errors
                $errorsBefore = count($user->getErrors($attribute));
                $validator->validate($user, [$attribute]);
                $errorsAfter = count($user->getErrors($attribute));
                if (get_class($validator) == 'CUniqueValidator' && $errorsBefore < $errorsAfter) {
                    // we ignore uniqness checks (this checks if user with specified email or username registered),
                    // because we will ask user for password, to check if this account belongs to him
                    $errors = $user->getErrors($attribute);
                    $ignored[] = end($errors);
                }
            }
        }

        $errors = [
          'email'    => $user->getErrors($emailAtt),
          'username' => $user->getErrors($nameAtt),
        ];

        if (count($ignored)) {
            //removing ignored errors
            foreach ($ignored as $message) {
                foreach (['email', 'username'] as $attribute) {
                    $index = array_search($message, $errors[$attribute]);
                    if ($index !== false) {
                        if (strpos($this->scenario, '_pass') === false || empty($this->password)) {
                            $errors[$attribute][$index] = $this->confirmStr($attribute);
                        } else // when we have scenario with '_pass' and we are here, than user entered valid password, so we simply unsetting errors from uniqness check
                        {
                            unset($errors[$attribute][$index]);
                        }
                    }
                }
            }
            if (strpos($this->scenario, '_pass') === false) {
                $this->scenario .= '_pass';
            }
        }

        $this->addErrors($errors);

        return !$this->hasErrors();
    }
}
