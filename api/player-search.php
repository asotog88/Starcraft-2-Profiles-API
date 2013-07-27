<?

/** 
 * Takes all the info for a player and makes a best search on sc2ranks.
 * Params can include name, region, search type, page to take.
 * This script only get results as presented in sc2rance. Filtering or sorting is done on iphone to reduce server load.
 * We do not know how many searches in one page since that may vary.
 * On iphone, users can filter results for a specific league. In this case, it will still grab one page of data from this script.
 */

require_once('../classes/SC2Search.php');
require_once('../helpers/RestUtils.php');

$options = array();
$options['content'] = $_REQUEST['content'];
$options['url'] = $_REQUEST['url'];
$options['league'] = $_REQUEST['league'];  // bronze, silver, gold, platinum, diamond, master, grandmaster

// If no content, we try to return target url by looking at other params
if ( ( !isset($options['content'] ) || $options['content'] == '' ) && 
     ( !isset($options['url']) || $options['url'] == '' ) ) {
    // Constants
    $defaultParams = array(
                           'game' => 'hots',  // hots (heart of the swarm or wol (wings of libert))
                           'region' => 'global',
                           'ladder' => '1v1', // 1v1, 2v2, 3v3, 4v4, 2v2r, 3v3r, 4v4r
                           'league' => 'all', //all, grandmaster, master, diamond, platinum, gold, silver, bronze
                           'name' => 'Draco',
                           'type' => 'exact');
    
    // Get basic parameters
    $options = array();
    $options['game'] = $_REQUEST['game'];  
    $options['region'] = $_REQUEST['region'];
    $options['ladder'] = $_REQUEST['ladder'];       
    $options['league'] = $_REQUEST['league'];
    $options['name'] = $_REQUEST['name'];       
    $options['type'] = $_REQUEST['type'];  
    
    $options = GeneralUtils::getDefaults($defaultParams, $options);
    
    // We need to grab the content with user supplied options
    $targetURL = SC2Search::getTargetURL($options);
    
    // Get URL to use
    GeneralUtils::printJSON(json_encode(array('targetUrl' => $targetURL)));
    //RestUtils::sendResponse(200, $targetURL, '', 'text-plain');
    exit;
}

// Get the content for the user if an url is provided but no content is
if ( isset($options['url']) && strlen($options['url']) > 0 
     && (!isset($options['content']) || strlen($options['content']) == 0) ) {
  // Get contents for provided url
  $urlconnect = new URLConnect($options['url'], 100, FALSE);
  if ( $urlconnect->getHTTPCode() != 200 ) {
    RestUtils::sendResponse($urlconnect->getHTTPCode());
    exit;
  }
  $options['content'] = $urlconnect->getContent();
}

// Set default return type
$defaultParams = array('type' => 'json', 'content' => '');
$options = GeneralUtils::getDefaults($defaultParams, $options);

$sc2search = new SC2Search($options);
if ( $options['type'] == 'html' ) {
  $sc2search->addThingsToPrint("<h2><a href=\"$targetURL\">$targetURL</a></h2>");
  $sc2search->displayArray();
}else if ( $options['type'] == 'json' ){
  GeneralUtils::printJSON($sc2search->parseSearchResultsContent());
}
?>