<?php
/*
Plugin Name: Sort Page Lists by Last Name
Plugin URI: http://studiohyperset.com/wordpress-plugin-sort-wp_list_pages-generated-page-lists-by-last-name/4451
Description: Aimed at archivists and other WordPress developers who use the names of individuals as page titles, this plugin sorts <code>wp_list_pages</code>-generated page lists by last name. More generally, the plugin can also be used to sort <code>wp_list_pages</code>-generated page lists by the last word of any page's title. After installing and activating, developers can order any <code>wp_list_pages</code>-generated page list by surname -- or, more generally, last word -- using the <code>sortbylastname=1</code> parameter, e.g., <code>&lt;?php wp_list_pages('title_li=&sortbylastname=1'); ?&gt;</code>. Use a "0" to (temporarily) disable the plugin. <em>w/ special thanks to <a href="http://www.ryanajarrett.com">Ryan Jarrett</a></em>
Version: 1.0
Author: Studio Hyperset, Inc. 
Author URI: http://studiohyperset.com/posts
License: GPL3
*/

	function last_name_page_sort($val, $attr, $content = null) {
		if ($attr[sortbylastname]==1) { 
				$lines = explode("\n", $val); // Type "\\n" before saving in the WordPress code editor.
				$newval="";
				foreach ($lines as $key => $line) {
					if (strlen($line)>10) {
						$start = strrpos($line, '">')+2;
						$end = strpos(substr($line, $start), '</a>');
						$orig_title = substr($line, $start, $end);
						
						$start_last_word = strrpos($orig_title, " ")+1;
						$new_title = substr($orig_title, $start_last_word) . ", " . substr($orig_title, 0, $start_last_word-1);
						$line = str_replace($orig_title, $new_title, $line);
						$newlines[$line] = $new_title;
					}
				}
				asort($newlines);
				foreach ($newlines as $key => $line) { $newval .= $key; }
		} else {
				$newval = $val;
		}
		return $newval;
	}
	add_filter('wp_list_pages','last_name_page_sort',50,3);
?>