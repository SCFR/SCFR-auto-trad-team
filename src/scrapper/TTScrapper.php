<?php
namespace SCFR\AutoTradTeam\scrapper;

use SCFR\AutoTradTeam\article\TradTeamArticle;


/**
 * Responsible for scrapping an article from the TradTeam website
 */
class TTScrapper extends XMLScrapper {
    protected $parse_url = "http://starcitizen-traduction.fr/feed/";
    
    public function scrape() {
        $xml = $this->get_xml();
        $this->write_last_scrape();

        if($xml && $xml->channel) {
            foreach($xml->channel->item as $item) $this->for_each_item($item);
        }

    }

    protected function for_each_item($item) {
        echo "<pre>";
        //if(!$this->check_was_scraped($item->pubDate)) {
            $article = new TradTeamArticle($item);
           print_r($article);
        //}
    }
}


?>