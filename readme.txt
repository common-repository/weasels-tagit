=== Weasel's TagIt! ===
Contributors: weasello
Donate link: 
Tags: tag, tagging, old tags, archives, edit, maintenance
Requires at least: 2.0.2
Tested up to: 2.3.1
Stable tag: 1

A plugin that redirects you to a post with no tags (or failing that, a random post) so that you can add tags to those old posts of yours.

== Description ==

This is a plugin that displays a link to your latest article that does not contain tags, and provides you with an editing link for it as well. This will help you update all your older articles that don’t have tags on them.

If all of your articles have tags, it instead selects the article with the fewest number of tags.

This is a great plugin to slowly (but surely!) let you and all of your site editors apply tags to those old articles, thus making them more easily accessible to your readers and search engines.

== Installation ==

1. Upload `wz_tagit.php` or it's containing directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the following template tag to your website:

   `<?php wz_tagit(); ?>`

   I strongly recommend making the template tag in an editor-only viewable area, as the edit link simply won't work for anybody else. Do this by putting the following code in, for example, your sidebar:

   `<?php if (current_user_can('edit_Posts') wz_tagit(); ?>`

== Screenshots ==

1. This is a screenshot of the template tag as shown on my site.
