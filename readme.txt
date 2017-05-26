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


== Upgrade Notice ==

First version, so nothing to adjust.

== Frequently Asked Questions ==

= What parameters are available? =

The parameters the viewer understands are:

* id: necessary if more than one viewer will be contained in one post. Default is 'demo'
* locale: the locale to use for displaying the moves, default is 'en'
* fen: the position where the game starts, default is the initial position
* piecestyle: the pieces to use, default is 'merida'. Availabe are: 'wikipedia', 'alpha', 
'uscf', 'case', 'condal', 'leipzig', 'chesscom', and 'beyer'.
* orientation: 'white' or 'black', default is 'white'
* theme: the theme defines the overall board, color, pieces, ... Current are: green, zeit, chesscom, informator, 
sportverlag, beyer, falken, blue
* boardsize: the size of the board, if it should be different to the size of the column.
* size: the size of the column to print the board, the buttons, the moves, ...

= Where can I find more information about the implementation? =

Have a look at the GitHub repository https://github.com/mliebelt/PgnViewerJS-WP and the sister repository
https://github.com/mliebelt/PgnViewerJS (which contains the implementation in Javascript).

== Screenshots ==

1. Example for use of pgnView (shortcode pgnv).
2. Example for use of pgnEdit (shortcode pgne).
3. Example for use of pgnBoard (shortcode pgnb).
4. Example for use of pgnPrint (shortcode pgnp).

== Changelog ==

= 0.9.5 =

* Current version of PgnViewerJS as published on GitHub.
* Fixed minor things by adding CSS file for WordPress only.

= 0.9.4 =
* First version made public