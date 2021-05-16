=== Plugin Name ===
Contributors: mliebelt
Donate link: 
Tags: chess, pgn
Requires at least: 4.6
Tested up to: 5.7
Stable tag: 1.1.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Integration of PgnViewerJS into WordPress.

== Description ==

Integration of PgnViewerJS into WordPress. This is a small layer around the original [PgnViewerJS](https://github.com/mliebelt/PgnViewerJS), but is needed to use it in a WordPress installation. At the end, it should provide the following interfaces:

     [pgnv]1. e4 e5 2. ...[/pgnv]

This is the PgnViewer (mostly needed): allows to play through a game (including variations), printing the comments, NAGs, ...

     [pgne]1. e4 ...[/pgne]

Allows to edit and view a game. At the end, you may use the PGN button to display the notation,  that then may be copied again in the WordPress post entry.

     [pgnb fen=<a FEN string>][/pgnb]

Just to display a board (only), no moves.

     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]

Allows to print a game in a format similar to magazines and books. For that purpose, the notation  of PGN was expanded by the "D" at the end of a move, that stands for the diagram.

For a list of available parameters, look into the Frequently Asked Questions.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress


== Upgrade Notice ==

= 1.1.3 =

* Added all known parameters of PgnViewerJS of version 1.5.3
* Ensure that all parameters are written in the correct format

= 1.1.2  =

* Upgrade the implementation to the latest version of PgnViewerJS 1.5.3 that fixes the Fontawesome problem on theme 2021.
* Fixed some of the whitespace bugs.

= 1.1.0  =

* Upgrade the implementation to the latest version of PgnViewerJS.
* Fixed some of the whitespace bugs.

= 0.9.8 =

* Allow starting a game from a defined move.
* Added notation for circles and arrows, with creating them in editing mode.
* Add color marker for the player at move.
* Show result in move list.
* Some small bug fixes of previous versions.

= 0.9.7 =

* Added some parameters that were now available from PgnViewerJS.
* Replace chessboard.js by Chessground (from lichess.org)

== Frequently Asked Questions ==

= What parameters are available? =

The parameters the viewer understands are:

* id: May be set by the user or generated automatically by the system.
* locale: the locale to use for displaying the moves, default is 'en'. Available are: cs, da, de, en, es, et, fi, fr, hu, is, it, nb, nl, pl, pt, ro, sv.
* fen: the position where the game starts, default is the initial position.
* show_notation: default true, if false, hides the ranks and columns on the board.
* piecestyle: the pieces to use, default is 'merida'. Availabe are: 'wikipedia', 'alpha', 'uscf', 'case', 'condal', 'leipzig', 'chesscom', 'maya', 'merida', and 'beyer'.
* orientation: 'white' or 'black', default is 'white'.
* theme: the theme defines the overall board, color, pieces, ... Current are: green, zeit, chesscom, informator, sportverlag, beyer, falken, blue
* boardsize: the size of the board, if it should be different to the size of the column.
* size: the size of the column to print the board, the buttons, the moves, ...
* moveswidth: used to size the width of the moves section. Needed for layout == left | right
* movesheight: used to size the height of the moves section. Needed for layout == left | right
* layout: top, bottom, left, right, top-left, top-right, bottom-left, bottom-right
* startplay: move from which the game should be started
* showresult: true, if the result of the game should be shown inside the notation, default false
* colormarker: default none, options are: cm, cm-big, cm-small, circle, circle-big, circle-small


The following code shows how to use some of the parameters in a page:

    [pgnv locale=fr piecestyle=uscf orientation=black theme=zeit size=500px]1. e4 e5 2. Nf3 Nc6[/pgnv]

= Where can I find more information about the implementation? =

Have a look at the GitHub repository https://github.com/mliebelt/PgnViewerJS-WP and the sister repository https://github.com/mliebelt/PgnViewerJS (which contains the implementation in Javascript).

== Screenshots ==

1. Example for use of pgnView (shortcode pgnv).
2. Example for use of pgnEdit (shortcode pgne).
3. Example for use of pgnBoard (shortcode pgnb).
4. Example for use of pgnPrint (shortcode pgnp).

== Changelog ==

= 0.9.8 =

* Allow starting a game from a defined move.
* Added notation for circles and arrows, with creating them in editing mode.
* Add color marker for the player at move.
* Show result in move list.
* Some small bug fixes of previous versions.

= 0.9.7 =

* Replaced chessboard.js by Chessground (board of lichess.org)
* Many bug fixes in PgnViewerJS

= 0.9.5 =

* Current version of PgnViewerJS as published on GitHub.
* Fixed minor things by adding CSS file for WordPress only.
* Added  generation of ID if it is missing

= 0.9.4 =

* First version made public
