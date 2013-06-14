<?php

/*
Plugin Name: Marquee xml rss feed scroll
Description: Marquee xml rss feed scroll is a simple wordpress plugin to create the marquee in the website with rss feed.
Author: Gopi.R
Version: 6.0
Plugin URI: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
Author URI: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
Donate link: http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
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

add_shortcode( 'rss-marquee', 'mxrf_shortcode' );

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

function mxrf_shortcode( $atts ) 
{
	global $wpdb;
	//[rss-marquee rssfeed="RSS1"]
	if ( ! is_array( $atts ) ) 
	{ 
		return ''; 
	}
	$type = $atts['rssfeed'];
	
	//@$type =  $matches[1];
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
	add_option('mxrf_rss3', "http://www.gopiplus.com/work/category/word-press-plug-in/feed/");
	add_option('mxrf_rss4', "http://www.gopiplus.com/work/category/word-press-plug-in/feed/");
	add_option('mxrf_rss5', "http://www.gopiplus.com/work/category/word-press-plug-in/feed/");
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
	//No action required.
}

function mxrf_option() 
{
	global $wpdb;
	?>
	<div class="wrap">
	  <div class="form-wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"><br>
		</div>
		<h2>Marquee xml rss feed</h2>
		<h3>Plugin setting</h3>
	<?php

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
		//	Just security thingy that wordpress offers us
		check_admin_referer('mxrf_form_setting');
		
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
	
	echo '<label for="tag-title">Title :</label><input  style="width: 250px;" type="text" value="';
	echo $mxrf_title . '" name="mxrf_title" id="mxrf_title" /><p></p>';
	
	echo '<label for="tag-title">Scroll amount :</label><input  style="width: 100px;" type="text" value="';
	echo $mxrf_scrollamount . '" name="mxrf_scrollamount" id="mxrf_scrollamount" /><p></p>';
	
	echo '<label for="tag-title">Scroll delay :</label><input  style="width: 100px;" type="text" value="';
	echo $mxrf_scrolldelay . '" name="mxrf_scrolldelay" id="mxrf_scrolldelay" /><p></p>';
	
	echo '<label for="tag-title">Scroll direction :</label><input  style="width: 100px;" type="text" value="';
	echo $mxrf_direction . '" name="mxrf_direction" id="mxrf_direction" /><p>Enter Left (or) Right</p>';
	
	echo '<label for="tag-title">Scroll style :</label><input  style="width: 250px;" type="text" value="';
	echo $mxrf_style . '" name="mxrf_style" id="mxrf_style" /><p></p>';
	
	echo '<label for="tag-title">Spliter :</label><input  style="width: 100px;" type="text" value="';
	echo $mxrf_spliter . '" name="mxrf_spliter" id="mxrf_spliter" /><p></p>';
	
	echo '<label for="tag-title">Target :</label><input  style="width: 100px;" type="text" value="';
	echo $mxrf_target . '" name="mxrf_target" id="mxrf_target" /> <p> Enter: _blank   (or)   _parent   (or)   _new</p>';
	
	echo '<label for="tag-title">Rss feed 1 :</label><input  style="width: 450px;" type="text" value="';
	echo $mxrf_rss1 . '" name="mxrf_rss1" id="mxrf_rss1" /><p> (RSS1) This is default for widget</p>';
	
	echo '<label for="tag-title">Rss feed 2 :</label><input  style="width: 450px;" type="text" value="';
	echo $mxrf_rss2 . '" name="mxrf_rss2" id="mxrf_rss2" /><p>(RSS2)</p>';
	
	echo '<label for="tag-title">Rss feed 3 :</label><input  style="width: 450px;" type="text" value="';
	echo $mxrf_rss3 . '" name="mxrf_rss3" id="mxrf_rss3" /><p>(RSS3)</p>';
	
	echo '<label for="tag-title">Rss feed 4 : </label><input  style="width: 450px;" type="text" value="';
	echo $mxrf_rss4 . '" name="mxrf_rss4" id="mxrf_rss4" /><p>(RSS4)</p>';
	
	echo '<label for="tag-title">Rss feed 5 : </label><input  style="width: 450px;" type="text" value="';
	echo $mxrf_rss5 . '" name="mxrf_rss5" id="mxrf_rss5" /><p>(RSS5)</p>';
	
	echo '<input name="mxrf_submit" id="mxrf_submit" lang="publish" class="button-primary" value="Click to Update" type="Submit" />';
	
	wp_nonce_field('mxrf_form_setting');
	
	echo '</form>';
	?>
    <h2>Plugin configuration option</h2>
    <ol>
		<li>Drag and drop the widget.</li>
		<li>Add the plugin in the posts or pages using short code.</li>
		<li>Add directly in to the theme using PHP code.</li>
    </ol>
    Check official website for more information <a href="http://www.gopiplus.com/work/2011/08/10/marquee-xml-rss-feed-scroll-wordpress-scroll/" target="_blank">click here</a>
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