<?php
namespace SCFR\AutoTradTeam\scrapper;

/**
 * Responsible for scrapping an article from an RSS feed
 */
abstract class XMLScrapper {
    /** the rss feed url */
    protected $parse_url;
    /** the last time we scrapped this rss feed */
    protected $last_scrape_time;

    /**
     * Start scrapping the target to try and produce SampleArticles if need be
     *
     * @return void
     */
    public function scrape() {
        $xml = $this->get_xml();
        $this->write_last_scrape();

        if($xml && $xml->channel) {
            foreach($xml->channel->item as $item) $this->for_each_item($item);
        }

    }

    /**
     * Inner loop function executed on each item in a scrape
     *
     * @param SimpleXMLElement $item
     * @return void
     */
    protected function for_each_item($item) {
    }

    /**
     * Loads the correct xml file
     *
     * @return SimpleXMLElement the whole rss feed
     */
    protected function get_xml() {
        $this->last_scrape_time = $this->get_last_scrape();
        return \simplexml_load_file('compress.zlib://'.$this->parse_url);
    }

    /**
     * Checks the date of a given article against the last scrape date
     * to determine if we already posted that article.
     *
     * @param RFC822-string $date 
     * @return boolean true if already scrapped, false otherwise
     */
    protected function check_was_scraped($date) {
        $article_time = strtotime($date);

        return $article_time <= $this->last_scrape_time;
    }

    public function get_last_scrape() {
        return (integer) \file_get_contents($this->get_cache_file_name());
    }

    /**
     * Writes to cache the date of the last scrape
     * @return void
     */
    protected function write_last_scrape() {
        $this->ensure_cache_folder();
        file_put_contents($this->get_cache_file_name(), time());
    }

    private function ensure_cache_folder() {
        if(!\is_dir($this->get_cache_file_directory()) || !\is_writable($this->get_cache_file_directory()))
        throw new \Exception("Can't write to cache folder, ensure it exists and is writable");
    }

    protected function get_cache_file_directory() {
        return __DIR__."/../../cache/";
    }

    /**
     * @return string the name of the cache file for this rss feed
     */
    protected function get_cache_file_name() {
        return $this->get_cache_file_directory().hash("crc32", $this->parse_url).".txt";
    }

}


?>