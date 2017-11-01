Here are the things that remain todo. If solved, move to the solved section.

## TODO

* I have used locales on an example page, so it should be possible
* What is the best deployment scheme? Currently I have the following options:
  * Use github.io for the distribution of PgnViewerJS and take the files from there. Then I have the problem from
  above (as I understand it).
  * Distribute all files together with the wordpress plugin. This is 1.5 MB (with all files), and even 0.7 MB
  when the Javascript file is compressed. It includes currently a copy of jQuery, which could be removed as well.
  But the remaining files will be significant. This is the only distribution that is currently working ...
* The layout of the board needs too much place. I should find ways for displaying board, moves and navigation elements
  so that not such much place is wasted.
* Find alternative ways to scale, so that depending on the wordpress theme, the layout of the board and moves may be different.
* Bugs / Problems
  * Empty move section leads to a fault (should be a bug in pgnView)
  * Position parameter was ignored (now possible with fen, not position)
  
  
### Check the following

* All parameters you can find in the source code.
* Compare those with the parameters that can be found in [the documentation](http://mliebelt.github.io/PgnViewerJS/docu/docu.html).
  
### Issues

  
## Solved

* Bugs / Problems
  * The images for FontAwesome are not displayed. CSS seems to be correct. ==> Had to add directory fonts from the dist-directory.
