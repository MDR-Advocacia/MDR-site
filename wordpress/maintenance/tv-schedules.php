<?php
// Invoked only by the host's dedicated timer, inside the private WordPress.
define('WP_CLI',true);require '/var/www/html/wp-load.php';
if(!function_exists('mdr_tv_schedule_tick')){fwrite(STDERR,"TV scheduler module unavailable\n");exit(75);}
try{echo wp_json_encode(mdr_tv_schedule_tick())."\n";}catch(Throwable $e){fwrite(STDERR,get_class($e).': '.$e->getMessage()."\n");exit(1);}
