<?php

/*
        code by Peter Mileshko 
        Контроллер для работы с моделью - БД / талица Tasks

*/

namespace School\controllers;



class Tasks extends Controller {

    private $id;

    use TraitControllers;
    
    public function __construct ($rest) {
        parent::__construct ($rest);
        $this->id = parent::getValue('id');
    }
    
    /**
     * 
     * @return json
     */

        public function action_getTasks() {

            $tasks = $this->getValue( null, null , $this->query['action']);

                if( $tasks ) {
                     return json_encode($tasks, JSON_UNESCAPED_UNICODE);
                    }

            $message = 'Заданий в базе нет';

             $this->fail($message);
        } 

    /**
     * 
     * @return json
     */
        public function action_getTask() {

             $task = $this->getValue( null, $this->id, $this->query['action']);

                if( $task ) {
                     return json_encode($task, JSON_UNESCAPED_UNICODE);
                    }

           $message = 'Задание не найдено id='.$this->id;

             $this->fail($message);

        }

    /**
     * 
     * @return json
     */
        public function action_Insert() {


            $result =  $this->setValue(null, array_slice($this->query, 2) , $this->query['action']);

            if( $result ) {

            return json_encode(['result'=>'positive', 'message'=>$result], JSON_UNESCAPED_UNICODE);
            }

            $this->fail('Ошибка при добавлении задания в таблицу ');
        }

    /**
     * 
     * @return json
     */

         public function action_Update() {

            $result =  $this->setValue( 'id='.$this->id, array_slice($this->query, 3) , $this->query['action']);

                    if( $result ) {

                     return json_encode(['result'=>'positive', 'message'=>$result], JSON_UNESCAPED_UNICODE);
                    }

             $this->fail('Ошибка обновления задания в таблицу ');
        } 



}

?>