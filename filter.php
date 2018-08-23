<?php
/**
 * GGB Material filter.
 *
 * @package    filter_ggbm
 * @copyright  2018 Quizdidaktik.de
 * @author     Joachim Jakob <jakj@kronberg-gymnasium.de.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class filter_ggbm extends moodle_text_filter {
    
    public function filter($text, array $options = array()) {
        
        if (!is_string($text) or empty($text)) {
            // Non-string data can not be filtered anyway.
            return $text;
        }
 
        if (stripos($text, 'ggbm:') === false) {
            // Performance shortcut - if there is no such tag, nothing can match.
            return $text;
        }
 
 
        // Here we can perform some more complex operations with the ggbm: in the text.
        
        $search = '/ggbm:[a-zA-Z0-9]{8}/';
        
        //$newtext = $text;
        
        $newtext = preg_replace_callback($search, 'filter_ggbm_replace_callback', $text);

        return $newtext;
    }
}

function filter_ggbm_replace_callback($fundstelle) {
    $embedcode = '<iframe scrolling="no" class="ggbm_filter_iframe" src="https://www.geogebra.org/material/iframe/id/';
    //echo "<script>console.log('PHP: '+".gettype($fundstelle[0]).");</script>";
    $alstext=(string)$fundstelle[0];    
    $nurid=explode(':' , $alstext)[1];
    $embedcode .= $nurid; 
    $embedcode .= '/width/640/height/480/border/888888/smb/false/stb/false/stbh/false/ai/false/asb/false/sri/true/rc/true/ld/false/sdz/true/ctl/true/sfsb/true" width="640px" height="480px" style="border:0px;" allowfullscreen></iframe>';
    $embedcode .= '<br /><a href="https://www.geogebra.org/m/';
    $embedcode .= $nurid;
    $embedcode .= '" target="_blank">auf Geogebra.org öffnen</a>';
    return $embedcode;
}

?>
