<?php

/*

					code by Peter Mileshko
					Основной контроллер и маршрутизатор

					Автозагрузчик классов

*/



require_once 'Init.php';


try {

$queryLog = new Log(LOG_FILE);

$rest = Init::initialize($queryLog);


    if ($rest['controller']) {
    
    $instance = new $rest['controller']($rest);
      
    http_response_code(200);
    $answer = $instance->request();
    $queryLog->save( null , $answer);
    $queryLog->close();
    echo $answer;

    }
    else {
           throw new Exception('Ошибка передачи данных');
    }

 }
catch(Exception $e) {

           $answer = json_encode(['result'=>'negative','message'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
           $queryLog->save( null , $answer);
           $queryLog->close();
           http_response_code(404);
           echo $answer;

 }
catch(PDOException $e) {

           $answer = json_encode(['result'=>'negative','message'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
           $queryLog->save( null , $answer);
           $queryLog->close();
           http_response_code(404);
           echo $answer;
 }


?>