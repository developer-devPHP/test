<?php

class Application_Model_UsersDBWork extends Zend_Db_Table
{

    private $My_DB;

    public function __construct ()
    {
        $this->My_DB = $this->getDefaultAdapter();
    }
    public function login ($login, $pass)
    {
        // Получить экземпляр Zend_Auth
        $auth = Zend_Auth::getInstance();
        
        // Создаем Adapter для Zend_Auth, указывая ему где в БД искать логин и
        // пароль для сравнения
        $authAdapter = new Zend_Auth_Adapter_DbTable($this->My_DB, 'users_login', 
                'username', 'password', "MD5(?)");
        
        $authAdapter->setIdentity($login)->setCredential($pass);
        
        // Проверяет и сохраняет результат проверки
        $result = $auth->authenticate($authAdapter);
        
        if ($result->isValid())
        {
            // Успешно
            
            // Можно записать в сессию некоторые поля
           /* $auth->getStorage()->write(
                    $authAdapter->getResultRowObject(
                            array(
                                    'user_ID',
                                    'username'
                            )));
                            */
            
            // Получить объект Zend_Session_Namespace
            
            $session = new Zend_Session_Namespace('Zend_User_Login');
            $session->__set('users_params',$authAdapter->getResultRowObject(
            		array(
            				'user_ID',
                            'username',
            				'company_id'
            		))
            );
            
           // $session = new Zend_Session_Namespace('Zend_Auth');
            // Установить время действия залогинености
            $session_time = 1 * 24 * 60 * 60;
            $session->setExpirationSeconds($session_time);
                                                                     
            // если отметили "запомнить"
            if (isset($_POST['remember_me']) && $_POST['remember_me'] == 1)
            {
                $session_time = 15 * 24 * 60 * 60;
                Zend_Session::rememberMe($session_time);
            }
            $data = array(
                    'last_login_date' => date('Y-m-d H:i:s' ,time() ),
            );
            $this->My_DB->update('users_login', $data);
            
            return true;
        }
        
        // Неудачно
        $error_msg = "Username or Password is incorrect"; /*
                                                           *
                                                           * $result->getMessages();
                                                           */
        return $error_msg;
    }
}