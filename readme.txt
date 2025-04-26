=== Plugin Name ===
Contributors: mliebelt
Donate link:
Tags: chess, pgn
Requires at least: 4.6
Tested up to: 6.8
Stable tag: 2.0.5
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Integration of @mliebelt/pgn-viewer into WordPress (formarly named PGNViewerJS).

== Description ==

=== Using Shortcodes ===

To use a shortcode, do the following steps:

1. Enter on a new element `/shortcode`.
2. Enterinside the element then the shortcode including the content of the following sections.

==== Basic View ====

     [pgnv]1. e4 e5 2. ...[/pgnv]

This is the PgnViewer (mostly needed): allows to play through a game (including variations), printing the comments, NAGs, ...

==== Edit Mode ====

     [pgne]1. e4 ...[/pgne]

Allows to edit and view a game. At the end, you may use the PGN button to display the notation,  that then may be copied again in the WordPress post entry.

==== Single Position (or Board) ====

     [pgnb fen=<a FEN string>][/pgnb]

Just to display a board (only), no moves. Leave out the pgn, if possible. If pgn is included, it will be checked and has to be correct (but not shown at the end).

==== Print View ====

     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]

Allows to print a game in a format similar to magazines and books. For that purpose, the notation  of PGN was expanded by the "D" at the end of a move, that stands for the diagram. (Caveat: "D" is currently not working, and leading to an error. See issue [#580](https://github.com/mliebelt/pgn-viewer/issues/580) about that.)

For a list of available parameters, look into the Frequently Asked Questions.

=== Using Block Level Element ===

You can use instead the following:

1. Enter as block element `/PGN Viewer Block Editor`, in the variants ` View`, ` Edit`, ` Board` or ` Print`.
2. You will then have a form with all options that are possible with the shortcode as well.
3. Depending on the kind of element you want to have, different values are needed:
    * View: all possible
    * Edit: same as view
    * Board: only FEN and layout elements of the board
    * Print: most not needed.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= What parameters are available? =

The parameters the viewer understands are:

* id: May be set by the user or generated automatically by the system.
* locale: the locale to use for displaying the moves, default is 'en'. Available are: cs, da, de, en, es, et, fi, fr, hu, is, it, nb, nl, pl, pt, ro, sv.
* position: the position where the game starts, default is the initial position.
* showcoords: default true, if false, hides the ranks and columns on the board.
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
* notation: default short, option is: long
* notationlayout: default inline, option is: list
* showfen: default false, option: true. Shows an additional text editor for the FEN of the current position.
* coordsfactor: default 1, by using a different number, coords font is grown or shrunk.
* coordsfontsize: alternative, set the size of the font in pixel
* timertime: default 700, number of milliseconds between moves
* hidemovesbefore: default false, if set to true, hide the moves before move denoted by startplay


The following code shows how to use some of the parameters in a page:

    [pgnv locale=fr piecestyle=uscf orientation=black theme=zeit size=500px]1. e4 e5 2. Nf3 Nc6[/pgnv]

= What if I want to use most of the parameters the same all the time? =

There is a Javascript variable `PgnBaseDefaults` that you could set. Do the following:

* Go as admin of your Wordpress site to Appearance > Theme Editor
* Search on the right the theme file named `Theme Header` (== `header.php`).
* Search inside that file the section that begins with `<head>`.
* Insert somewhere before the plugins are loaded the following: `<script>const PgnBaseDefaults = { locale: 'de', layout: 'left',  size: '720px' }</script>` (of course with the defaults you like).

When you now create new pages, you can leave out the parameters you have already set per default. And you can of course overwrite them by having individual parameters set in the call.

= Where can I find more information about the implementation? =

Have a look at the GitHub repository https://github.com/mliebelt/PgnViewerJS-WP and the sister repository https://github.com/mliebelt/PgnViewerJS (which contains the implementation in Javascript).

== Screenshots ==

1. Example for use of pgnView (shortcode pgnv).
2. Example for use of pgnEdit (shortcode pgne).
3. Example for use of pgnBoard (shortcode pgnb).
4. Example for use of pgnPrint (shortcode pgnp).
5. Example of using the block level element to allow all modes.

== Changelog ==

= 2.0.5 =

* Upgrade to pgn-viewer version 1.6.11 (with some bug fixes in the viewer).

= 2.0.4 =

* Correction in readme.txt, to have the current release.

= 2.0.3 =

* Fix problem with global PGN, ensure that PGN is not filtered.
* Allow fen as alias for position, and size for width (previous versions had those attributes).

= 2.0.2 =

* Parse shortcode for `pgnv` alone, don't convert to anything.

= 2.0.1 =

* Ensures that escaped code is handled correctly.
* Ignores time information in PGN (which renders else ugly)

= 2.0.0 =

* Updates the pgn-viewer version to 1.6.10.
* Provides additonal block editor for convenience.

= 1.5.13 =

* Upgarde to version 1.5.13 of PgnViewerJS (so the big change in version number).
* Remove some of the defaults, so that those defaults may be overwritten by setting `PgnBaseDefault`. See the FAQ to that topic.

= 1.1.5 =

* Upgraded to version 1.5.6 of PgnViewerJS.

= 1.1.4 =

* Updated PHP file with version as well.

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

= 0.9.5 =

* Current version of PgnViewerJS as published on GitHub.
* Fixed minor things by adding CSS file for WordPress only.
* Added  generation of ID if it is missing

= 0.9.4 =

* First version made public
