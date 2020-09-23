    <?php

            //          Обработчик запросов Post

//          Для оптимизации кода, конструкции if elseif можно будет заменить на единый переключаль switch для обработки всех форм проекта

       if ($_POST['userLogin'] and $_POST['userPass'] ) {
        
        if(checkName(multiStrip($_POST['userLogin']),$dbConnect) == 0 ) {
            require_once('config/tplib.php');
            $content = '<span class="errorMsg">Пользователь с таким именем не найден.</span>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
        
        $user = loginUser(multiStrip($_POST['userLogin']),multiStrip($_POST['userPass']),$dbConnect);
        
        if ($user!='') {
          
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_name'] = $user['login'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_priv'] = $user['priv_status'];
            $_SESSION['user_confirm'] = $user['confirm'];
            $_SESSION['Administrate'] = ( $user['priv_status'] == 1 ) ? 1 : '';
            $_SESSION['authVisited'] = 1;
            $pg=5;
        }
        else {
            require_once('config/tplib.php');
            $content = '<span class="errorMsg">Пароль введен неверно.</span>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
    }
    elseif ($_POST['newLogin'] and $_POST['newPass']) {
        
        if( checkName(multiStrip($_POST['newLogin']), $dbConnect) == 0 ) {
            
        if( $_POST['new']) { 
            $_SESSION['Administrate'] = 6;
            $resultReg = registerUser( multiStrip($_POST['newLogin']), multiStrip($_POST['newPass']), multiStrip($_POST['newEmail']), (int)multiStrip($_POST['newPriv']), (int)multiStrip($_POST['newConfirm']), $dbConnect);
        }         
        else $resultReg = registerUser( multiStrip($_POST['newLogin']), multiStrip($_POST['newPass']), multiStrip($_POST['newEmail']),0,0, $dbConnect);
            
                if($resultReg) {
                    require_once('config/tplib.php');
                    
                    if( $_SESSION['Administrate'] == 6 ) {
                        
                    $content = '<span class="successMsg">Пользователь: '.multiStrip($_POST['newLogin']).' добавлен.</span><br>';
                        
                    require('engine/account.php');
                        
                    }
                    else {
                    $content = '<span class="successMsg">Регистрация прошла успешно.</span>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass']);

                    require('engine/authreg.php');
                    }
                    
                    mysqli_close($dbConnect);
                    exit();
                }
                else {
                    require_once('config/tplib.php');

                    $content = '<span class="errorMsg">Не удалось зарегистрировать. Ошибка записи в БД.</span>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass'])."<br>Email = ".multiStrip($_POST['newEmail']);

                    if($_SESSION['Administrate'] == 6) require('engine/account.php');
                    else require('engine/authreg.php');
                    
                    mysqli_close($dbConnect);
                    exit();
                }
        }
        else {      require_once('config/tplib.php');
                    $content = '<span class="errorMsg">Введенное имя уже занято.</span>';
              
                    if($_POST['new']) { $_SESSION['Administrate']=6; require('engine/account.php'); }
                    else require('engine/authreg.php');
              
                    mysqli_close($dbConnect);
                    exit();
                }
        
    }
    elseif ($_POST['account']) {

                   
                switch ( (int)multiStrip($_POST['account']) ) {
                    case 1:     // Закрываем авторизацию
                        destroyAuthorisation();
                            session_destroy();
                        $pg = 4;
                                break;
                    case 2: ; // для смены пароля
                        

                        break;
                    case 3:             // добавление товара в корзину 
                        require_once('config/tplib.php');
                        
                        if( empty($_SESSION['user_id']) ) {
                                        
                            $content = '<span class="errorMsg">Авторизуйтесь на сайте.</span>';
                            break;
                        }
                        
                        if($_GET['id']) {
                          
                            if( !addToBasket( (int)multiStrip($_GET['id']), $_SESSION['user_id'],$dbConnect) ) {
                                $content = '<span class="errorMsg">Ошибка записи в БД. Корзина.</span>';
                            }
                            
                        }
                        else $content = '<span class="errorMsg">Ошибка добавления в корзину: товар не в БД.</span>';
                        
                        break;
                    case 4:             // Оформить заказ пользователя на основе его корзины
                        $_SESSION['Administrate'] = 4;
                        require_once('config/tplib.php'); 
                        
                                if(!( empty($_SESSION['user_id']) )) {
                                    
                            if($_SESSION['basket_amount']) {
                                
                                $amountPending = checkOrdersStatus( $_SESSION['user_id'], $dbConnect);
                                if($amountPending) {
                                    $content = '<span class="errorMsg">У вас есть неоформленный заказ на сумму:</span>'.$amountPending.' '.$Currency[0].'<br><span class="errorMsg">Перейдите в <a href="/?page=5">личный кабинет</a> для завершения заказа.</span>';
                                }
                                elseif( !$newOrder_id=createOrder( $_SESSION['user_id'], $_SESSION['basket_amount'], $dbConnect) ) {
                                    $content = '<span class="errorMsg">Ошибка оформления заказа:</span>';
                                }
                                else {
                                    $pg=5; // если успешно создали новый заказ, перенаправляем в личный кабинет в раздел заказы для завершения оформления
                                    $_SESSION['new_order']=$newOrder_id;
                                    unset($_SESSION['basket_amount']); // обнуляем переменную общая сумма корзины
                                }
                            }
                            else $content = '<span class="errorMsg">Ваша корзина пуста.</span>';
                        }
                        else $content = '<span class="errorMsg">Авторизуйтесь на сайте.</span>';
                        
                        break;
                    case 5:             // Очистить корзину пользователя
                        $_SESSION['Administrate'] = 5;
                        require_once('config/tplib.php');  
                        
                        if(!( empty($_SESSION['user_id']) )) {
                            
                            if( !deleteBasket( $_SESSION['user_id'],$dbConnect) ) 
                                $content = '<span class="errorMsg">Ошибка удаления корзины пользователя:</span>'.$_SESSION['user_name'];
                            else unset($_SESSION['basket_amount']);
                        }
                        break;
                    case 6: // Админка базы пользователей
                        $_SESSION['Administrate'] = 6;
                        break;
                    case 7: // Админка базы товаров
                        $_SESSION['Administrate'] = 7;
                        break;
                    case 11: // Админ панель - Добавить товар в базу
                        $_SESSION['Administrate'] = 7;
                        require_once('config/tplib.php');
                        if( $_POST['nameProduct'] and $_POST['imgProduct'] and $_POST['productDisc'] and $_POST['productPrice'] ) {
                            
                            if( checkProduct(multiStrip($_POST['nameProduct']), $dbConnect) ) {
                                    $content ='<span class="errorMsg">Продукт с именем - '.multiStrip($_POST['nameProduct']).' уже есть в БД.</span><br>'; break; }
         $imgPath = getImagePath( (int)multiStrip($_POST['imgProduct']), $dbConnect);
$result = addProduct(multiStrip($_POST['nameProduct']), (int)multiStrip($_POST['imgProduct']), $imgPath['path'], multiStrip($_POST['productDisc']), multiStrip($_POST['productPrice']), $dbConnect);
                            if($result) {
                                $content ='<span class="successMsg">Товар успешно добавлен в БД.</span><br>';
                                        }
                            
                            else $content ='<span class="errorMsg">Не удалось добавить'.multiStrip($_POST['nameProduct']).' в БД.</span><br>';
                            
                        }
                        else $content = '<span class="errorMsg"> Необходимо заполнить все поля.</span>';
                            
                        break;
                    case 8: // Админка базы Заказы
                        $_SESSION['Administrate'] = 8;

                        break;
                    case 9: // Админка базы Изображения
                        $_SESSION['Administrate'] = 9;

                        
                        break;   
                    case 10: // Админка базы Изображения - добавление файла с изображением                        
                        $_SESSION['Administrate'] = 9;
                         require_once('config/tplib.php');
                        
                        if($_POST['nameProduct']) {
                            
                                if($_FILES['imageFile']['error']) $content ='<span class="errorMsg">Ошибка загрузки файла No 1</span><br>';
                                elseif ($_FILES['imageFile']['size'] > 512000) $content ='<span class="errorMsg">Размер файла превышает 500 Кб</span><br>';
                                elseif ($_FILES['imageFile']['type'] == 'image/jpeg') {
                                    
                                    $imagePath = PATHIMG.$_FILES['imageFile']['name'];

                                        
                                    if ( copy($_FILES['imageFile']['tmp_name'], $imagePath) ) {
                                        $imagePath = '/'.$imagePath;
                                        
                                        $result = addImage( multiStrip($_POST['nameProduct']),$imagePath, $dbConnect );     // функция из dblib.php добавление новой кратинки в БД
                            
                                        if($result) $content = '<span class="successMsg">Изображение '.$imagePath.' добавлено в БД.</span><br>';
                                        else $content = '<span class="errorMsg">Не удалось добавить изображение '.$imagePath.' в БД.</span><br>';
                                    }
                                    else $content ='<span class="errorMsg">Ошибка загрузки файла '.$imagePath.' No 2</span><br>';
                                } 
                                else $content ='<span class="errorMsg">Файл должен быть формата jpeg</span><br>';
                            
                        }
                        else $content = '<span class="errorMsg">Необходимо ввести наименование товара соответсвующее картинки.</span>';
                        
                        break;
                     case 12: // Завершение заказа и подготовка к доставке                       
                    unset($_SESSION['Administrate']);
                         require_once('config/tplib.php');
                    if( $_POST['Surname'] and $_POST['Firstname'] and $_POST['Middlename'] and $_POST['postCode'] and $_POST['Address'] and  $_POST['order_id'] ) {  
                        $surName = multiStrip($_POST['Surname']);
                        $firstName = multiStrip($_POST['Firstname']);
                        $middleName = multiStrip($_POST['Middlename']);
                        $postCode = multiStrip($_POST['postCode']);
                        $address = multiStrip($_POST['Address']);
                        $addInfo = multiStrip($_POST['addInfo']);
                        $order_id = (int)multiStrip($_POST['order_id']);
                        
                        $orderReport = orderReport($firstName,$surName,$middleName,$postCode,$address,$addInfo,$order_id,$_SESSION['order_list'],$templates[20]);
                        
                        processOrder($order_id, $orderReport, $dbConnect); //  обнавляем статус заказа как оформленный и принятый к доставке и сохраняем бланк заказа
                        unset($_SESSION['order_list']);

                        }
                    default: break;
                }
    }
    elseif ($_POST['fbName'] and $_POST['fbText']) {
        
            require_once('config/tplib.php');
               
                    if ( file_exists($feedBackData) ) {

                         $fileOpen = fopen($feedBackData,"a"); 

                        if ($fileOpen) {

                                    fwrite($fileOpen,date('d-m-Y').'<br>' );
                                    fwrite($fileOpen,multiStrip($_POST['fbName']).'<br>' );
                                    fwrite($fileOpen,multiStrip($_POST['fbText']).'<br>' );
                                    fwrite($fileOpen,'<hr>');
                                    fclose($fileOpen);  

                        }
                            else $content = '<span class="errorMsg">Ваш отзыв не отправлен. Невозможно открыть журнал на запись.</span>';

                    }
                    else $content = '<span class="errorMsg">Файл журнала записей отсутсвует</span>';
        
require('engine/feedback.php');
                    mysqli_close($dbConnect);
                    exit();
        
    }
?>
