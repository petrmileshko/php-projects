<?

include "Cfg/config.php";

try {

    Page::run()
        ->action()
        ->render();
    
 }
catch(Exception $e) {
        die($e->getMessage());
 }
catch(PDOException $e) {
            die($e->getMessage());
 }

?>
