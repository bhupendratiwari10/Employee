<?php 
// Prevent direct access
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    exit('Direct access not permitted');
}

define('FULL_PATH', dirname(__FILE__));
define('PROJECT_URL', 'https://employee.tidyrabbit.com/');
define('DATABASE_HOST', 'localhost');  // Fixed typo
define('DATABASE_NAME', 'u984874713_zwindia_soft');
define('DATABASE_USER', 'u984874713_zwindia_root');
define('DATABASE_PASSWORD', 'UEws49t2iM@EhAa');
?>