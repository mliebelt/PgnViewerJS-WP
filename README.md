PgnViewerJS-WP
==============

Integration of PgnViewerJS into WordPress. This is a small layer around the original
[PgnViewerJS](https://github.com/mliebelt/PgnViewerJS), but is needed to use it in a
WordPress installation. At the end, it should provide the following interfaces:

    [pgnv]1. e4 e5 2. ...[/pgnv]
     
This is the PgnViewer (mostly needed): allows to play through a game (including variations),
     printing the comments, NAGs, ...
     
     
     [pgne]1. e4 ...[/pgne]
     
Allows to edit and view a game. At the end, you may use the PGN button to display the notation,
     that then may be copied again in the WordPress post entry.
     
     [pgnb position=<a FEN string>][/pgnb]

Just to display a board (only), no moves.
     
     [pgnp]1. e4 e5D 2. Nf3 Nc6D ...[/pgnp]
     
Allows to print a game in a format similar to magazines and books. For that purpose, the notation
     of PGN was expanded by the "D" at the end of a move, that stands for the diagram.

### Build ###

The build is done with Grunt, so the `package.json` file helps how to install the necessary tools. After installation, do the following steps:

* Go into the root directory (with node.js, npm and Grunt installed).
* Call there `grunt` without any arguments.
* This will build the distribution currently named `PgnViewerJS-WP.zip`.
* Go to your wordpress website (as administrator), and upload the plugin.
* Activate the plugin in Wordpress.
* Build an example page with the following in it: `[pgne]1. e4[/pgne]`
* Save the page, and open it in wordpress.

If everything works well, you will have now a page with a rendered chessboard in it, which is in edit mode, so you may now add moves that are shown in the section below. Read the documentation of [PgnViewerJS](http://mliebelt.github.io/PgnViewerJS/docu/index.html) what to do with the tool then.

### Planed ###

* The final goal is to allow some users in wordpress to edit a game and to save it, so others may view it.
For this purpose, I have to learn and find out a lot:
  * Is there an API I can use to store the games external to pages?
  * What is the role model in Wordpress and does it support what I want to do?

### Configuration ###

This will explain the configuration options that are directly supported ... Details will be contained in the
father implementation, so only the mapping in Wordpress has to be explained.

### Reference ###

* [GitHub](https://github.com/mliebelt/PgnViewerJS): Here is the original JavaScript implementation available.
* [PgnV Demo](http://mliebelt.github.io/PgnViewerJS/docu/examples.html#1000): Demonstration web site for the features that are currently inluded in PgnViewerJS, and may soon be integrated into the Wordpress plugin in a similar way.