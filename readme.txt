=== Plugin Name ===
Contributors: mliebelt
Donate link: 
Tags: chess, pgn
Requires at least: 4.6
Tested up to: 4.7
Stable tag: /trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Integration of PgnViewerJS into WordPress.

== Description ==

Integration of PgnViewerJS into WordPress. This is a small layer around the original
[PgnViewerJS](https://github.com/mliebelt/PgnViewerJS), but is needed to use it in a
WordPress installation. At the end, it should provide the following interfaces:

    [pgnv]1. e4 e5 2. ...[/pgnv]
     
This is the PgnViewer (mostly needed): allows to play through a game (including variations), printing the comments, NAGs, ...
    
     [pgne]1. e4 ...[/pgne]
     
Allows to edit and view a game. At the end, you may use the PGN button to display the notation,  that then may be copied again in the WordPress post entry.
     
     [pgnb position=<a FEN string>][/pgnb]

Just to display a board (only), no moves.
     
     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]
     
Allows to print a game in a format similar to magazines and books. For that purpose, the notation  of PGN was expanded by the "D" at the end of a move, that stands for the diagram.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress


== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.9.5 =
* First version made public