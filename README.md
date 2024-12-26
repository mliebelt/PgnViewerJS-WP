PgnViewerJS-WP
==============

Integration of PgnViewerJS into WordPress. This is a small layer around the original [PgnViewerJS](https://github.com/mliebelt/PgnViewerJS), but is needed to use it in a WordPress installation. The plugin should work in 2 different ways: providing a shortcode, and providing a Gutenberg block element. Both should lead at the end to the same result.

### Shortcode

To use a shortcode, do the following steps:

1. Enter on a new element `/shortcode`.
2. Enterinside the element then the shortcode including the content of the following sections.

#### Basic View ####

    [pgnv]1. e4 e5 2. ...[/pgnv]
     
This is the PgnViewer (mostly needed): allows to play through a game (including variations),
     printing the comments, NAGs, ...
     
#### Edit Mode ####     

     [pgne]1. e4 ...[/pgne]
     
Allows to edit and view a game. At the end, you may use the PGN button to display the notation,
     that then may be copied again in the WordPress post entry.
     
#### Single Position ####

     [pgnb fen=<a FEN string>][/pgnb]

Displays a board position only, no moves.
     

#### Print View ####

     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]
     
Allows to print a game in a format similar to magazines and books. For that purpose, the notation
     of PGN was expanded by the "D" at the end of a move, that stands for the diagram.

### Block Level Element

You can use instead the following:

1. Enter as block element `/PGN Viewer JS`, in the variants ` View`, ` Edit`, ` Board` or ` Print`. 
2. You will then have a form with all options that are possible with the shortcode as well.
3. Depending on the kind of element you want to have, different values are needed:
    * View: all possible
    * Edit: same as view
    * Board: only FEN and layout elements of the board
    * Print: most not needed.

### Build ###

The build is done with Grunt, so the `package.json` file helps how to install the necessary tools. After installation, do the following steps:

* Go into the root directory (with node.js, npm and Grunt installed).
* Run `grunt` without any arguments.
* This will build the distribution currently named `PgnViewerJS-WP.zip`.
* Go to your WordPress website (as administrator), and upload the plugin.
* Activate the plugin in WordPress.
* Build an example page with the following in it: `[pgne]1. e4[/pgne]`
* Save the page, and open the URL to the page.

If everything works well, you will have now a page with a rendered chessboard in it, which is in edit mode, so you may now add moves that are shown in the section below. Read the documentation of [PgnViewerJS](http://mliebelt.github.io/PgnViewerJS/docu/index.html) what to do with the tool then.

### Planned ###

* Update the implementation to use the new box model. At the moment, users have to include classic boxes to have the chess games visualized.
* Allow to have a default configuration, so that has not to be repeated all the time on each page.

### Configuration ###

This will explain the configuration options that are directly supported. Details will be contained in the father implementation, so only the mapping in WordPress has to be explained. Here is a list of the relevant parameters:

* `position`: Gives the FEN string of the start position of the game. Default is the inital position.
* `orientation`: values are `white` (default) or `black`.
* `layout`: values are `top` (default, board at the top, moves at the bottom) or `left` (board at the left, moves at the right).
* `size`: the width of the column including everything, like `750px`.
* `boardsize`: the width of the board alone, like `400px`.
* `locale`: the locale to use for tooltips and the move SAN notation. Values are: `en`, `de`, `fr`, `es` and many more.
* `piecestyle`: values are `merida` (default), `wikipedia`, `alpha`, `uscf`, `case`, `condal`, `maya`, `leipzig`, `beyer` and `chesscom`.
* `theme`: values are `zeit` (default), `green`, `chesscom`, `informator`, `sportverlag`, `beyer`, `falken`, `blue`.

For other configuration parameters, see the [online documentation of the configuration of the original viewer](https://mliebelt.github.io/PgnViewerJS/docu.html). Convention here is, that the parameters are all lowercase in WP, but converted then back for the call of `PgnViewerJS`.

A complete example looks like:

    [pgnv position="r1bq1rk1/1p2nppp/1bp2n2/4p3/P1B1P3/B1P2N2/3N1PPP/R2QK2R b KQ - 3 13" 
    orientation=black layout=left size=750px boardsize=400px locale=de ] 
    13... Bxf2+!? 14. Kxf2 Ng4+ 15. Kg1? (15. Ke2 Qb6 16. Qg1) Qb6+! 16. Nd4 exd4 
    17. Rb1 Qa7 18. Qf3 d3+ 19. Kf1 Ne3+ 20. Ke1 Bg4 21. Qg3 Nc2+ 22. Kf1 Be2# [/pgnv]

### Reference ###

* [GitHub](https://github.com/mliebelt/PgnViewerJS): Here is the original JavaScript implementation available.
* [PgnV Demo](https://mliebelt.github.io/PgnViewerJS/examples.html#1000): Demonstration web site for the features that are currently inluded in PgnViewerJS, and may soon be integrated into the Wordpress plugin in a similar way.
* [Grunt](https://gruntjs.com/getting-started): Grunt documentation
