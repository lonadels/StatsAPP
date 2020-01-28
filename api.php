<?

use SwiftOf\StatsApp\Main;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include $class . '.php';
});

new Main($_GET);