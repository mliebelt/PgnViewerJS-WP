PgnViewerJS-WP
==============

Integration of PgnViewerJS into WordPress. This is a small layer around the original
[PgnViewerJS](https://github.com/mliebelt/PgnViewerJS), but is needed to use it in a
WordPress installation. At the end, it should provide the following interfaces:

    [pgnv]1. e4 e5 2. ...[/pgnv]
     
This is the PgnViewer (mostly needed): allows to play through a game (including variations),
     printing the comments, NAGs, ...
     
### Planed ###

     
     [pgne]1. e4 ...[/pgne]
     
Allows to edit and view a game. At the end, you may use the PGN button to display the notation,
     that then may be copied again in the WordPress post entry.
     
     [pgnb position=<a FEN string>][/pgnb]

Just to display a board (only), no moves.
     
     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]
     
Allows to print a game in a format similar to magazines and books. For that purpose, the notation
     of PGN was expanded by the "D" at the end of a move, that stands for the diagram.
     
### Configuration ###

This will explain the configuration options that are directly supported ...

### Reference ###

* [GitHub](https://github.com/mliebelt/PgnViewerJS): Here is the original JavaScript implementation available.
* [PgnV Demo](http://mliebelt.github.io/PgnViewerJS/docu/examples2.html#1000): Demonstration web site for the features that are currently inluded in PgnViewerJS, and may soon be integrated into the Wordpress plugin in a similar way.