<?php
include_once (dirname(__FILE__) . '/../../../../classes/SC2Search.php');
include_once (dirname(__FILE__) . '/../../../../classes/SC2Player.php');
include_once (dirname(__FILE__) . '/../../../../classes/SC2Division.php');

/**
 * Description of WebServicesController
 *
 * @author alejandro.soto
 */
class WebServicesController extends CradleCoreController {

    public function __construct() {

    }

    /**
     * Search players action
     * for example: /api/v2/player/search/tankan?game=wol
     *
     */
    public function searchPlayer() {
        $options = array();
        $options['game'] =  $this->params->getParam('game');
        $options['region'] = $this->params->getParam('region');
        $options['ladder'] = $this->params->getParam('ladder');
        $options['league'] = $this->params->getParam('league');
        $options['name'] = $this->params->getParamFromUrl('player');
        $options['type'] =  $this->params->getParam('type');

        $options = GeneralUtils::getDefaults(SC2Search::$SEARCH_RESULTS_URL_DEFAULT_PARAMS, $options);

        $targetURL = SC2Search::getTargetURL($options);
        $urlconnect = new URLConnect($targetURL, 100, FALSE);
        if ( $urlconnect->getHTTPCode() != 200 ) {
            /* TODO display error message */
            return;
        }
        $options['content'] = $urlconnect->getContent();
        $options['type'] = 'json';
        $options = GeneralUtils::getDefaults(SC2Search::$SEARCH_RESULTS_DEFAULT_OPTIONS, $options);

        $sc2search = new SC2Search($options);
        $data = array('search_url' => $targetURL, 'results' => json_decode($sc2search->parseSearchResultsContent()));
        $this->done(array('data' => json_encode($data)));
    }
    
    /**
     * Loads player info action
     * for example: /api/v2/player/info?url=http://us.battle.net/sc2/en/profile/3923192/1/Tankan/
     * 
     */
    public function loadPlayerInfo() {
        $options = array();
        $options['url'] =  $this->params->getParam('url');
        $options['game'] = $this->params->getParam('game');
        if (isset( $options['url'])) {
            $options = GeneralUtils::getDefaults(SC2Player::$PLAYER_INFO_DEFAULT_PARAMS, $options);
            $urlconnect = new URLConnect($options['url'], 100, FALSE);
            if ( $urlconnect->getHTTPCode() != 200 ) {
                /* TODO: error handle */
                exit;
            }
            $options['content'] = $urlconnect->getContent();
            $sc2player = new SC2Player($options['content'], $options['url'], $options['game']);
            $data = $sc2player->getJsonData();
            $this->done(array('data' => $data));
            return;
        }
        /* TODO display error message */
    }
    
    /**
     * Loads the player division status
     * for example: /api/v2/player/division?url=http://us.battle.net/sc2/en/profile/3923192/1/Tankan/ladder/leagues
     * 
     */
    public function loadPlayerDivision() {
        $options = array();
        $options['url'] =  $this->params->getParam('url');
        $options['game'] = $this->params->getParam('game');
        if (isset($options['url'])) {
            $options = GeneralUtils::getDefaults(SC2Player::$PLAYER_INFO_DEFAULT_PARAMS, $options);
            $urlconnect = new URLConnect($options['url'], 100, FALSE);
            if ( $urlconnect->getHTTPCode() != 200 ) {
                /* TODO: error handle */
                exit;
            }
            $options['content'] = $urlconnect->getContent();
            $sc2division = new SC2Division($options);
            $divisionData = $sc2division->parseDivision();
            $this->done(array('data' => json_encode($divisionData)));
        }
        /* TODO display error message */
    }

}

?>
