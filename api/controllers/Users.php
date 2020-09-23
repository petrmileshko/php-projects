<?php

/*
        code by Peter Mileshko 
        Контроллер для работы с моделью - БД / талица Users

*/

namespace School\controllers;



class Users extends Controller {

    private $email;
    private $password;
    private $id;


    use TraitControllers;
    
    public function __construct ($rest) {

        parent::__construct ($rest);
        $this->email = parent::getValue('email');
        $this->password = parent::getValue('pass');
        $this->id = parent::getValue('id');
    }

    /**
     * 
     * @return json
     */
    
    public function action_login() {

        if( !$this->passport and !$this->data ) {

            $user = $this->getValue( null,[ 'email'=>$this->email , 'pass'=>$this->password ], $this->query['action']);

                if ( $user ) {

                    $this->passport = new \School\models\Passport($user);
                    $user += $this->passport->get(); 

                    return json_encode($user, JSON_UNESCAPED_UNICODE);
                }
                else {
                $message = 'Ошибочный email: ('.$this->email.') или пароль.';
                $this->fail($message);                
                }

            }
                $message = 'Уже авторизованы';
                $this->fail($message);  
    } 

    /**
     * 
     * @return json
     */
    
    public function action_logout() {

        if( $this->passport or $this->data ) {

                \School\models\Passport::destroy();

                return json_encode(['result'=>'positive','message'=>'Signed off']);
            }
            $this->fail('Вы не авторизованы '); 
    } 

    /**
     * 
     * @return json
     */
    

        public function action_getUser() {

              $user = $this->getValue( null, $this->id, $this->query['action']);

                if( $user ) {
                     return json_encode($user, JSON_UNESCAPED_UNICODE);
                    }

           $message = 'Пользователь не найден : '.$this->id;

            $this->fail($message); 

        }

    /**
     * 
     * @return json
     */

    public function action_getUsers() {

            $users = $this->getValue( null, null , $this->query['action']);

                if( $users ) {
                     return json_encode($users, JSON_UNESCAPED_UNICODE);
                    }

             $this->fail('Пользователей в базе нет');
        } 


    /**
     * 
     * @return json
     */

         public function action_Update() {

            $result =  $this->setValue( 'id='.$this->id, array_slice($this->query, 3) , $this->query['action']);

                    if( $result ) {

                     return json_encode(['result'=>'positive', 'message'=>$result]);
                    }

              $this->fail('Ошибка обновления пользователя '.$this->email);
        } 

    /**
     * 
     * @return json
     */
        public function action_Insert() {

            if( $this->is_Value( 'email', $this->email ) ) {
                $this->fail('Пользователь :'.$this->email.' зарегистрирован.');
            }

           $result =  $this->setValue(null, array_slice($this->query, 2) , $this->query['action']);

            if( $result ) {

            return json_encode(['result'=>'positive', 'message'=>$result]);
            }

            $this->fail('Ошибка добавления пользователя :'.$this->email);
        }
    
}

?>