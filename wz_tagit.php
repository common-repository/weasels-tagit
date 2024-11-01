<?php
/*
Plugin Name: Weasel's TagIt!
Plugin URI: http://wordpress.org/extend/plugins/weasels-tagit/
Description: A plugin that redirects you to a post with no tags (or failing that, a random post) so that you can add tags to those old posts of yours.
Author: Andy Moore
Version: 1
Author URI: http://www.thedailyblitz.org
*/

// ##### This plugin should be completely self contained and work totally on its own without any source editing. 
// ##### Add the following template tag to your template somewhere (perhaps in an admin-visible-only section?)
// ##### 		wz_taggit();
// ##### As an example, here's code I use in my sidebar, which shows the tagging link to only those that can add tags:
// #####
// ##### 			if (current_user_can('edit_posts'))
// #####                if (function_exists('wz_taggit'))
// #####                	wz_taggit();

// ##### ---------- NOTHING USER-CONFIGURABLE AFTER HERE ------------

function wz_taggit_get_theONE() { // ### Retrieves the article to be selected for tagging
	global $wpdb;
	
	$theONE = 0;
                                             // ### This query returns a list of all published posts.
        $sql = "SELECT DISTINCT ID
                FROM $wpdb->posts P
                WHERE P.post_status = 'publish' AND P.post_type = 'post'
                ORDER BY ID DESC";           // ### Order by DESC makes newer posts selected first
                                       
        $available_posts = $wpdb->get_col($sql);
		
  if (count($available_posts) > 0) { // ### if there's no posts yet no need to continue

	$sql = "SELECT object_id, COUNT(object_id) as Total
		FROM $wpdb->term_relationships TR, $wpdb->term_taxonomy TT
                WHERE TR.term_taxonomy_id=TT.term_taxonomy_id AND TT.taxonomy='post_tag'
                GROUP BY object_id
                ORDER BY Total ASC
		";       // ### This query returns a list of post-IDs that have tags, sorted by # of tags.
	$tagged_entries = $wpdb->get_col($sql);

        foreach ($available_posts as $scanning_post) {  // ### Comparing the two SQL queries to get the first post WITHOUT tags.
            if (!in_array($scanning_post, $tagged_entries)) {
              $theONE = $scanning_post;
              break;
            }            
        }

        if ($theONE == 0) {  // ### If everything is tagged, let's pick the article with the fewest tags instead.
          foreach ($tagged_entries as $scanning_tag)
            if (in_array($scanning_tag, $available_posts)) {
              $theONE = $scanning_tag;
              break;
            }
        } 
   }
	$result = $theONE; // ### I CHOOSE YOU
	return($result);
}

function wz_taggit() { // ### this is the template-tag function that actually displays the link to the article.

	$theONE = wz_taggit_get_theONE();
     if ($theONE > 0) { 
        $theLINK = get_permalink($theONE);   // #### Let's convert theONE to a URL
        $theEDITLINK = get_bloginfo('url') . '/wp-admin/post.php?action=edit&post=' . $theONE; // ### and an editable URL
        $results = '<a href="' . $theLINK . '">TagIt!</a> (<a href="'.$theEDITLINK.'">e</a>) <acronym title="You have edit powers, and this post needs more tags! DO IT">(?)</a>'; // #### and generate a proper HTML tag for it
     } else { $results = 'Tagit! (no posts found)'; } // ## and a little error message if we couldn't come up with anything.
	echo $results;
}
?>