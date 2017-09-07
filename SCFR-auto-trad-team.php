<?php /*
Plugin Name: SCFR Auto Trad Team
Author URI: https://starcitizen.fr
Description: SCFR Auto trad team loader
Version: 0.1
Author: SCFR Team
Author URI: https://starcitizen.fr
License: Private
*/
namespace SCFR;
\error_reporting(-1);
\ini_set("display_errors",1);
require __DIR__ . '/vendor/autoload.php';

$SCFR_AutoTradTeam = new AutoTradTeam\Main();

$test = new AutoTradTeam\scrapper\TTScrapper();
$test->scrape();

?>
