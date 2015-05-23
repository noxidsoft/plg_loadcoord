<?php
/*------------------------------------------------------------------------
# plg_loadcoord - Content - Load Coord
# ------------------------------------------------------------------------
# author    Noxidsoft
# copyright Copyright (C) 2014 Noxidsoft. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.noxidsoft.com
# Technical Support:  http://www.noxidsoft.com/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

class plgContentLoadcoord extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') {
			return true;
		}

		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'loadcoord') === false) {
			return true;
		}

		$mapMode 		= $this->params->def('mapMode', 0);
		$mapZoom 		= $this->params->def('mapZoom', 16);

		$regex		= '/{loadcoord\s+(.*?)}/i';
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

		// No matches, skip this
		if ($matches) {
			foreach ($matches as $match) {
				//print_r(strip_tags($match[1]));
				// link parent window
				if ($mapMode == 0) {
					$output = '<a href="http://maps.google.com/maps?q='.strip_tags($match[1]).'&z='.$mapZoom.'"><img style="padding-left:5px;" src="plugins/content/loadcoord/images/map.gif" alt="Map" /></a>';
				}

				// link new window
				if ($mapMode == 1) {
					//$output = '<a href="http://maps.google.com/maps?q='.strip_tags($match[1]).'&z='.$mapZoom.'" target="_blank"><img style="padding-left:5px;" src="plugins/content/loadcoord/images/map.gif" alt="Map" /></a>';
					$output = '<a href="https://maps.google.com/maps/place/'.str_replace(' ','',str_replace(',','+',strip_tags($match[1]))).'/@'.strip_tags($match[1]).','.$mapZoom.'z/" target="_blank"><img style="padding-left:5px;" src="plugins/content/loadcoord/images/map.gif" alt="Map" /></a>';
				}

				$article->text = preg_replace("|$match[0]|", addcslashes($output, '\\'), $article->text, 1);

			}
		}
	}
}

