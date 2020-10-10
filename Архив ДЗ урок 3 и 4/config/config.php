<?php
const PATH_MODELS = 'models/';
const PATH_ADMIN = 'admin/';
const PATH_USER = 'user/';
const CLASS_FILES = '.class.php';
const PATH_ASSETS = 'assets/';
const PATH_DATA = 'data/';
const PATH_IMAGES = 'images/';

const DB ='fotogallery'; //host1589827_fotogallery
const USER = 'root';    //host1589827_root
const PASS = '999asd999';
const SERV = 'localhost';
const TABI = 'images';
const TABU = 'user';
const TABG = 'goods';
const TOTAL_ROWS = 507;

use \site\user;
use \site\admin;
use \site\models;

function autoLoader($cName){
    
    $parseName = explode('\\',$cName);
    if(count($parseName)>1) { 
            $fileAdmin = PATH_MODELS.PATH_ADMIN.$parseName[count($parseName)-1].CLASS_FILES;
            $fileUser = PATH_MODELS.PATH_USER.$parseName[count($parseName)-1].CLASS_FILES;

            if(is_file($fileAdmin)) {
                include_once $fileAdmin;
            }

            if(is_file($fileUser)) {
                include_once $fileUser;     
            }
    }
    else {

        include_once PATH_MODELS.$cName.CLASS_FILES;
    }
}

spl_autoload_register('autoLoader');



?>