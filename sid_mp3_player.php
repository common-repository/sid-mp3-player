<?php
/*
Plugin Name: Sidney's MP3 Player
Version: Beta 4.1
Plugin URI: http://www.creativelycrazy.de/tag/wordpress
Description: For each mp3 file you reference in your post, this plugin shows a Flash player where your visitors can listen to the file
Author: Fabian "Sidney" Winter
Author URI: http://www.creativelycrazy.de
*/

function sid_mp3_player($text='You need the Flash player to listen to the stream.'){
	global $post;
	$custom_fields = get_post_custom();
	if(is_array( $custom_fields))
	{
    	while(list($key, $val) = each($custom_fields))
    	{ 
        	if(($key == 'enclosure' || $key == 'mp3') && is_array($val))
        	{
       			foreach($val as $enc)
       			{
	        		$enc = explode("\n",$enc);
   	    			if(!eregi('^http://.*',$enc[0]))
					{
						$enc[0] = get_bloginfo('url').'/'.$enc[0];
					};
					$files[] = trim($enc[0]);
				};
			};
		};
	};

	if($files)
	{
		sid_mp3_show_player($files,$text);
	};
}

function sid_mp3_show_player($files,$text='You need the Flash player to listen to the stream.'){
	foreach($files AS $key => $value)
	{
		if(!eregi('.*\.mp3',$value))
		{
			unset($files[$key]);
		};
	};
	$link = implode(',',$files);
	$playerurl = get_bloginfo('url').'/kubrik.swf';
	echo('<object type="application/x-shockwave-flash" data="'.$playerurl.'?src='.$link.'" width="355" height="28">
		<param name="movie" value="'.$playerurl.'?src='.$link.'" />
		<param name="quality" value="high" />
		'.$text.'
		</object>');
}

?>