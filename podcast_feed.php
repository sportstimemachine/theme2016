<?php echo '<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">';

/*
Template Name: Podcast
*/

$upload_dir = wp_upload_dir();
?>
  <channel>

    <title>Sports Time Machine Podcast - <?=ucfirst(str_replace('_',' ',$_REQUEST['station']))?></title>
    <description>Sports Time Machine Podcast - <?=ucfirst(str_replace('_',' ',$_REQUEST['station']))?> -Stark County Ohio</description>
    <link>http://sportstimemachine.net</link>
    <language>en-us</language>
    <copyright>Copyright 2012</copyright>
    <lastBuildDate>Wed, 15 Feb 2012 11:30:00 -0500</lastBuildDate>
    <pubDate>Wed, 15 Feb 2012 11:30:00 -0500</pubDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <webMaster>karl@casselbear.com (Karl Bear)</webMaster>

    <itunes:author>Sports Time Machine <?=str_replace('_',' ',ucfirst($_REQUEST['station']))?></itunes:author>
    <itunes:subtitle>Sports Time Machine <?=str_replace('_',' ',ucfirst($_REQUEST['station']))?> Podcast</itunes:subtitle>
    <itunes:summary>Sports Radio Show - Stark County Ohio</itunes:summary>

    <itunes:owner>
           <itunes:name>Sports Time Machine</itunes:name>
           <itunes:email>karl@casselbear.com (Karl Bear)</itunes:email>
    </itunes:owner>

<itunes:explicit>No</itunes:explicit>

<? /*<itunes:image href=""/>*/ ?>



<itunes:category text="Sports &amp; Recreation">
</itunes:category>
<?
 
$args = array(
                    	'post_type'=>''.str_replace('_','',$_REQUEST['station']).'posts',
                    	'numberposts'=>-1,
                    	'offset'=>0,
                    	'meta_key'=>'radio_show',
                    	'meta_compare'=>'>',
                    	'meta_value'=>'0'
                    );
               $posts = query_posts($args);
               $post = (array) $posts;


foreach ( $post as $podcast ){
$audio = get_post_custom($podcast->ID);
	$podcast = (array) $podcast;
	
	
	$audio_url = wp_get_attachment_url( $audio['audio'][0] );
	$audio_exp = pathinfo($audio_url);
	$dirname = explode("wp-content/uploads",$audio_exp['dirname']);
	$audio_filename = $audio_exp['basename'];
	$audio_abs_path = $upload_dir['basedir'].$dirname[1].'/'.$audio_filename;
	
	require_once('./getid3/getid3.php'); 
	$getID3 = new getID3();
	$mp3_info = $getID3->analyze($audio_abs_path);

	$duration_seconds = $mp3_info['playtime_seconds']; 
	$duration['minutes'] = floor($duration_seconds/60);
	$duration['seconds'] = str_pad(floor($duration_seconds%60),2,'0',STR_PAD_LEFT);
	
	?>

	
	<item>

	<title><![CDATA[<?=str_replace("&nbsp;"," ",stripslashes($podcast['post_title']))?>]]></title>
	
	<itunes:author>Sports Time Machine <?=str_replace('_',' ',ucfirst($_REQUEST['station']))?></itunes:author>
	
	<itunes:subtitle><?=str_replace("&nbsp;"," ",stripslashes(substr(strip_tags($podcast['post_content']),0,150)))?></itunes:subtitle>
	
	<enclosure url="<?=$audio_url?>" type="audio/mpeg" length="<?=filesize($audio_abs_path)?>" />
	<itunes:duration><?=$duration['minutes']?>:<?=$duration['seconds']?></itunes:duration>
	
	<guid><?=wp_get_attachment_url( $audio['audio'][0] );?></guid>
	
	<pubDate><?=date("D, j M Y H:i:s", strtotime($podcast['post_date']))?> EST</pubDate>
	
	<itunes:keywords>Sports, Sports Time Machine</itunes:keywords>
	
	</item>
	<?
	}

?>

</channel>

</rss>
