<?php

/*
Plugin Name: Marquee xml rss feed scroll
Description: Marquee xml rss feed scroll is a simple wordpress plugin to create the marquee in the website with rss feed.
Author: Gopi.R
Version: 4.0
Plugin URI: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
Author URI: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
Donate link: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
*/

/**
 *     Marquee xml rss feed scroll
 *     Copyright (C) 2012  www.gopiplus.com
 *     http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */	


function rssshow()
{
	global $wpdb;
	$mxrf_marquee = "";
	@$mxrf_scrollamount = get_option('mxrf_scrollamount');
	@$mxrf_scrolldelay = get_option('mxrf_scrolldelay');
	@$mxrf_direction = get_option('mxrf_direction');
	@$mxrf_style = get_option('mxrf_style');
	
	@$mxrf_rss1 = get_option('mxrf_rss1');
	@$mxrf_spliter = get_option('mxrf_spliter');
	@$mxrf_target = get_option('mxrf_target');
	
	if(!is_numeric($mxrf_scrollamount)){ $mxrf_scrollamount = 2; } 
	if(!is_numeric($mxrf_scrolldelay)){ $mxrf_scrolldelay = 5; } 
	
	if(@$mxrf_rss1  <> "")
	{
		@$url = $mxrf_rss1;
	}
	else
	{
		@$url = "http://www.gopiplus.com/work/feed/";
	}
	
	@$cnt=0;
	@$doc = new DOMDocument();
	@$doc->load( @$url );
	@$item = $doc->getElementsByTagName( "item" );
	if ( ! empty($item) ) 
	{
		@$count = 0;
		foreach( $item as $item )
		{
			$paths = $item->getElementsByTagName( "title" );
			$title = mysql_real_escape_string(mxrf_cdata($paths->item(0)->nodeValue));
			$paths = $item->getElementsByTagName( "link" );
			$links = mysql_real_escape_string(mxrf_cdata($paths->item(0)->nodeValue));
			if($count > 0)
			{
				@$spliter = $mxrf_spliter;
			}
			@$mxrf = @$mxrf . @$spliter . "<a target='".@$mxrf_target."' href='".$links."'>" . @$title . "</a>";
			$count = $count + 1;
			if($count == 11)
			{
				break;
			}
		}
	}
	$mxrf_marquee = $mxrf_marquee . "<div style='padding:3px;' class='mxrf_marquee'>";
	$mxrf_marquee = $mxrf_marquee . "<marquee style='$mxrf_style' scrollamount='$mxrf_scrollamount' scrolldelay='$mxrf_scrolldelay' direction='$mxrf_direction' onmouseover='this.stop()' onmouseout='this.start()'>";
	$mxrf_marquee = $mxrf_marquee . $mxrf;
	$mxrf_marquee = $mxrf_marquee . "</marquee>";
	$mxrf_marquee = $mxrf_marquee . "</div>";
	echo $mxrf_marquee;	
}

add_filter('the_content','mxrf_show_filter');

function mxrf_show_filter($content)
{
	return 	preg_replace_callback('/\[RSS-MARQUEE=(.*?)\]/sim','mxrf_show_filter_callback',$content);
}

function  mxrf_cdata($data) 
{
	$data = str_replace('<![CDATA[', '', $data);
	$data = str_replace(']]>', '', $data);
	if ( substr($data, -1) == ']' )
	{
		$data .= ' ';
	}
	return $data;
}


function mxrf_show_filter_callback($matches) 
{
	global $wpdb;
	
	@$type =  $matches[1];
	$mxrf_marquee = "";
	@$mxrf_scrollamount = get_option('mxrf_scrollamount');
	@$mxrf_scrolldelay = get_option('mxrf_scrolldelay');
	@$mxrf_direction = get_option('mxrf_direction');
	@$mxrf_style = get_option('mxrf_style');
	
	@$mxrf_rss1 = get_option('mxrf_rss1');
	@$mxrf_spliter = get_option('mxrf_spliter');
	@$mxrf_target = get_option('mxrf_target');
	
	if(!is_numeric($mxrf_scrollamount)){ $mxrf_scrollamount = 2; } 
	if(!is_numeric($mxrf_scrolldelay)){ $mxrf_scrolldelay = 5; } 
	
	if(@$type == "RSS1")
	{
		@$url = get_option('mxrf_rss1');
	}
	elseif(@$type == "RSS2")
	{
		@$url = get_option('mxrf_rss2');
	}
	elseif(@$type == "RSS3")
	{
		@$url = get_option('mxrf_rss3');
	}
	elseif(@$type == "RSS4")
	{
		@$url = get_option('mxrf_rss4');
	}
	elseif(@$type == "RSS5")
	{
		@$url = get_option('mxrf_rss5');
	}
	else
	{
		@$url = "http://www.gopiplus.com/work/feed/";
	}
	
	@$cnt=0;
	@$doc = new DOMDocument();
	@$doc->load( @$url );
	@$item = $doc->getElementsByTagName( "item" );
	if ( ! empty($item) ) 
	{
		@$count = 0;
		foreach( $item as $item )
		{
			$paths = $item->getElementsByTagName( "title" );
			$title = mysql_real_escape_string(mxrf_cdata($paths->item(0)->nodeValue));
			$paths = $item->getElementsByTagName( "link" );
			$links = mysql_real_escape_string(mxrf_cdata($paths->item(0)->nodeValue));
			if($count > 0)
			{
				@$spliter = $mxrf_spliter;
			}
			@$mxrf = @$mxrf . @$spliter . "<a target='".@$mxrf_target."' href='".$links."'>" . @$title . "</a>";
			$count = $count + 1;
			if($count == 11)
			{
				break;
			}
		}
	}
	$mxrf_marquee = $mxrf_marquee . "<div style='padding:3px;' class='mxrf_marquee'>";
	$mxrf_marquee = $mxrf_marquee . "<marquee style='$mxrf_style' scrollamount='$mxrf_scrollamount' scrolldelay='$mxrf_scrolldelay' direction='$mxrf_direction' onmouseover='this.stop()' onmouseout='this.start()'>";
	$mxrf_marquee = $mxrf_marquee . $mxrf;
	$mxrf_marquee = $mxrf_marquee . "</marquee>";
	$mxrf_marquee = $mxrf_marquee . "</div>";
	return $mxrf_marquee;	
}


function mxrf_install() 
{
	add_option('mxrf_title', "Marquee xml rss feed");
	
	add_option('mxrf_scrollamount', "2");
	add_option('mxrf_scrolldelay', "5");
	add_option('mxrf_direction', "left");
	add_option('mxrf_style', "color:#FF0000;font:Arial;");

	add_option('mxrf_rss1', "http://www.gopiplus.com/work/category/word-press-plug-in/feed/");
	add_option('mxrf_rss2', "http://www.gopiplus.com/extensions/feed");
	add_option('mxrf_rss3', "");
	add_option('mxrf_rss4', "");
	add_option('mxrf_rss5', "");
	add_option('mxrf_spliter', " - ");
	add_option('mxrf_target', "_blank");
}

function mxrf_widget($args) 
{
	extract($args);
	if(get_option('mxrf_title') <> "")
	{
		echo $before_widget;
		echo $before_title;
		echo get_option('mxrf_title');
		echo $after_title;
	}
	rssshow();
	if(get_option('mxrf_title') <> "")
	{
		echo $after_widget;
	}
}
	
function mxrf_control() 
{
	echo "Marquee xml rss feed";
}

function mxrf_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('marquee-xml-rss-feed', 'Marquee xml rss feed', 'mxrf_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('marquee-xml-rss-feed', array('Marquee xml rss feed', 'widgets'), 'mxrf_control');
	} 
}

function mxrf_deactivation() 
{

}

function mxrf_option() 
{
	global $wpdb;
	echo '<h2>Marquee xml rss feed </h2>';
	
	$mxrf_title = get_option('mxrf_title');
	
	$mxrf_scrollamount = get_option('mxrf_scrollamount');
	$mxrf_scrolldelay = get_option('mxrf_scrolldelay');
	$mxrf_direction = get_option('mxrf_direction');
	$mxrf_style = get_option('mxrf_style');
	
	$mxrf_rss1 = get_option('mxrf_rss1');
	$mxrf_rss2 = get_option('mxrf_rss2');
	$mxrf_rss3 = get_option('mxrf_rss3');
	$mxrf_rss4 = get_option('mxrf_rss4');
	$mxrf_rss5 = get_option('mxrf_rss5');
	$mxrf_spliter = get_option('mxrf_spliter');
	$mxrf_target = get_option('mxrf_target');
	
	if (@$_POST['mxrf_submit']) 
	{
		$mxrf_title = stripslashes($_POST['mxrf_title']);
		
		$mxrf_scrollamount = stripslashes($_POST['mxrf_scrollamount']);
		$mxrf_scrolldelay = stripslashes($_POST['mxrf_scrolldelay']);
		$mxrf_direction = stripslashes($_POST['mxrf_direction']);
		$mxrf_style = stripslashes($_POST['mxrf_style']);
		
		$mxrf_rss1 = stripslashes($_POST['mxrf_rss1']);
		$mxrf_rss2 = stripslashes($_POST['mxrf_rss2']);
		$mxrf_rss3 = stripslashes($_POST['mxrf_rss3']);
		$mxrf_rss4 = stripslashes($_POST['mxrf_rss4']);
		$mxrf_rss5 = stripslashes($_POST['mxrf_rss5']);
		$mxrf_spliter = stripslashes($_POST['mxrf_spliter']);
		$mxrf_target = stripslashes($_POST['mxrf_target']);
		
		update_option('mxrf_title', $mxrf_title );
		
		update_option('mxrf_scrollamount', $mxrf_scrollamount );
		update_option('mxrf_scrolldelay', $mxrf_scrolldelay );
		update_option('mxrf_direction', $mxrf_direction );
		update_option('mxrf_style', $mxrf_style );
		
		update_option('mxrf_rss1', $mxrf_rss1 );
		update_option('mxrf_rss2', $mxrf_rss2 );
		update_option('mxrf_rss3', $mxrf_rss3 );
		update_option('mxrf_rss4', $mxrf_rss4 );
		update_option('mxrf_rss5', $mxrf_rss5 );
		update_option('mxrf_spliter', $mxrf_spliter );
		update_option('mxrf_target', $mxrf_target );
	}
	
	echo '<form name="mxrf_form" method="post" action="">';
	
	echo '<p>Title :<br><input  style="width: 250px;" type="text" value="';
	echo $mxrf_title . '" name="mxrf_title" id="mxrf_title" /></p>';
	
	echo '<p>Scroll amount :<br><input  style="width: 100px;" type="text" value="';
	echo $mxrf_scrollamount . '" name="mxrf_scrollamount" id="mxrf_scrollamount" /></p>';
	
	echo '<p>Scroll delay :<br><input  style="width: 100px;" type="text" value="';
	echo $mxrf_scrolldelay . '" name="mxrf_scrolldelay" id="mxrf_scrolldelay" /></p>';
	
	echo '<p>Scroll direction :<br><input  style="width: 100px;" type="text" value="';
	echo $mxrf_direction . '" name="mxrf_direction" id="mxrf_direction" /> (Left/Right)</p>';
	
	echo '<p>Scroll style :<br><input  style="width: 250px;" type="text" value="';
	echo $mxrf_style . '" name="mxrf_style" id="mxrf_style" /></p>';
	
	echo '<p>Spliter :<br><input  style="width: 100px;" type="text" value="';
	echo $mxrf_spliter . '" name="mxrf_spliter" id="mxrf_spliter" /></p>';
	
	echo '<p>Target :<br><input  style="width: 100px;" type="text" value="';
	echo $mxrf_target . '" name="mxrf_target" id="mxrf_target" /> (_blank, _parent, _new)</p>';
	
	echo '<p>Rss feed 1 :<br><input  style="width: 350px;" type="text" value="';
	echo $mxrf_rss1 . '" name="mxrf_rss1" id="mxrf_rss1" /> (RSS1) <br>This is default for widget</p>';
	
	echo '<p>Rss feed 2 :<br><input  style="width: 350px;" type="text" value="';
	echo $mxrf_rss2 . '" name="mxrf_rss2" id="mxrf_rss2" /> (RSS2)</p>';
	
	echo '<p>Rss feed 3 :<br><input  style="width: 350px;" type="text" value="';
	echo $mxrf_rss3 . '" name="mxrf_rss3" id="mxrf_rss3" /> (RSS3)</p>';
	
	echo '<p>Rss feed 4 : <br><input  style="width: 350px;" type="text" value="';
	echo $mxrf_rss4 . '" name="mxrf_rss4" id="mxrf_rss4" /> (RSS4)</p>';
	
	echo '<p>Rss feed 5 : <br><input  style="width: 350px;" type="text" value="';
	echo $mxrf_rss5 . '" name="mxrf_rss5" id="mxrf_rss5" /> (RSS5)</p>';
	
	echo '<input name="mxrf_submit" id="mxrf_submit" lang="publish" class="button-primary" value="Update" type="Submit" />';
	echo '</form>';
	?>
    <h2>Plugin configuration option</h2>
    <ol>
    	<li>Drag and drop the widget</li>
        <li>Short code for posts and pages</li>
        <li>Add directly in the theme</li>
    </ol>
    Note: Check official website for more info <a href="http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/" target="_blank">click here</a>
    <?php
}

function mxrf_add_to_menu() 
{
	add_options_page('Marquee xml rss feed', 'Marquee xml rss feed', 'manage_options', __FILE__, 'mxrf_option' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'mxrf_add_to_menu');
}

add_action("plugins_loaded", "mxrf_widget_init");
register_activation_hook(__FILE__, 'mxrf_install');
register_deactivation_hook(__FILE__, 'mxrf_deactivation');
add_action('init', 'mxrf_widget_init');
?>