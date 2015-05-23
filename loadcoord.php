<?php
/*------------------------------------------------------------------------
# plg_loadcoord - Content - Load Coord
# ------------------------------------------------------------------------
# author    Noxidsoft
# copyright Copyright (C) 2012 Noxidsoft. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.noxidsoft.com
# Technical Support:  http://www.noxidsoft.com/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

$mainframe->registerEvent('onPrepareContent', 'plgContentLoadcoord');

function plgContentLoadcoord(&$article, &$params, $page=0)
{
	// simple performance check to determine whether bot should process further
	if (strpos($article->text, 'loadcoord') === false) {
		return true;
	}
		
	$mapMode 		= $params->get('mapMode', 0);
	$mapZoom 		= $params->get('mapZoom', 16);
	
	$regex		= '/{loadcoord\s+(.*?)}/i';
	preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

	// No matches, skip this
	if ($matches) {
		foreach ($matches as $match) {
			
			// link parent window
			if ($mapMode == 0) {
				$output = '<a href="http://maps.google.com.au/maps?q='.strip_tags($match[1]).'&z='.$mapZoom.'"><img style="padding-left:5px;" src="plugins/content/loadcoord/images/map.gif" alt="Map" /></a>';
			}
			
			// link new window
			if ($mapMode == 1) {
				$output = '<a href="http://maps.google.com.au/maps?q='.strip_tags($match[1]).'&z='.$mapZoom.'" target="_blank"><img style="padding-left:5px;" src="plugins/content/loadcoord/images/map.gif" alt="Map" /></a>';
			}
			
			$article->text = preg_replace("|$match[0]|", addcslashes($output, '\\'), $article->text, 1);
			
		}
	}
}
