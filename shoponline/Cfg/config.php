<?
	const DRIVER = 'mysql';
	const SERVER = 'localhost';
	const USERNAME = 'root';
	const PASSWORD = 'root';
	const DB ='shopmanager';
    const INDEX = ['get','post','files'];

    const IMAGES_PATH = 'Images/small/';
    const IMAGES_ORG_PATH = 'Images/original/';
    const DEFAULT_PATH = 'Data/';
    const IMAGE_NAME ='img';
    const MAX_IMAGES = 500;
    const IMAGE_SMALL_W = 220;
    const IMAGE_SMALL_H = 220;

    const PAGE_HEADER = '<h1><span id="shopTitle">Shop</span><span id="siteTitle">MANAGER</span></h1>';
//    const PAGE_HEADER = '<div class="logo"><img src="/Images/system/manager%20logo.jpg"></div>';
    const SHOP_HEADER = '<h1><span id="shopTitle">Shop</span><span id="siteTitle">ONLINE</span></h1><hr>';
    const PAGES = 'Pages/';
    const MODELS = 'Models/';
    const VIEWS = 'Views/';
    const DEF_PAGE = 'Shop';

function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
    }

include "Models/dBase.php";
include "Cfg/sys.php";
include "Controller/Page.php";
include "Models/Model.php";
include "Models/File.php";

?>