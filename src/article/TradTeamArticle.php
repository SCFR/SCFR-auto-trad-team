<?php
namespace SCFR\AutoTradTeam\article;


/**
 * TradTeam article
 */
class TradTeamArticle extends SampleArticle {
    /**
     * Creates a trad article from a scrapped xml
     *
     * @param SampleXMLElement $scaped
     */
    public function __construct($scraped) {
        $this->title = (string) $scraped->title;
        $this->content = (string) $scraped->description;
    
        $cat = [];
        foreach($scraped->category as $category) $cat[] = (string) $category;
        $this->categories = $cat;
    }
}

?>