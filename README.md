# Mobius Strip puzzle game

My implementation (as learning exercise) of the "[Infinite Loop](http://loopgame.co "Infinite loop home page")" (by [Jonas Lekevicius](http://lekevicius.com/projects/infinite-loop "Jonas Lekevicius's Infinite Loop page"), [Balys Valentukevicius](https://github.com/balysv "Balys' Github about page") Juste Ziliute). A puzzle game for Android and iOS. Which in turn was inspired by "Loops of Zen" by Arend Hintze.
I was inspired to build this after (starting to) read "Design Patterns: Elements of Reusable Object-Oriented Software" By Erich Gamma, Richard Helm, Ralph Johnson & John Vlissides.

Like Infinite Loop, the idea is simple, you start with a tile (currently: triangle, square, hexagon or octagon). The shape has one of a small number of possible unique pattern that can be joined together to form a larger unique pattern. Shapes are oriented at random. You tap or click on the shape to rotate it and ultimately, orientate the shape so that any lines coming out of the tapped shape join up with the lines of its neighbours.

## Patterns modes:
1.	random
2.	horizontally symmetrical
3.	vertically symmetrical
4.	both horizontally & vertically symmetrical
5.	diagonally symmetrical
6.	square, radially symmetrical (puzzle is divided inner four quadrants. The X border matches the Y border of the adjacent quadrant)

## Piece allocation modes:
1.	Linear - pieces are added left to right, to top bottom)
2.	Adjacent - a starting location is chosen at random then pieces are allocated to adjacent spots until all spaces are allocated.
3.	Random - locations are chosen at random pieces are chosen that can work in that location
__Note:__ piece patterns are chosen at random with reference to limitations set by surrounding pieces (if any).

## Favour random shapes:

Option to favour non-block layouts. I.e. favour puzzle patters whose shapes that are less square/rectangular.

## Puzzle pieces identification
*	Each different puzzle is given a number based on the number of connections it can make.
*	For shapes (like squares, hexagons & octagons) that can have multiple patterns for the same number of connections, a lower case letter is added to denote pattern for that number of connections
*	When a pattern can be mirrored, the letter is made uppercase.
*	blankPiece is always "0" (zero)
*	allPiece (connects on every face) is always "X"

## Repeatable Random patterns

## How pattern is generated
Using a seed

1.	X/Y dimensions are generated
2.	Pattern mode is chosen
3.	An allocation mode is chosen.
4.	An array is generated containing the X/Y co-ordinated of each pieces in the puzzle
5.	Number of blank edge pieces is chosen
6.	Blank edge piece (Any blank piece contiguous with the edge) are allocated
7.	Number of blank inner pieces is chosen
8.	Blank inner pieces are allocated
  1.	An unallocated space location is chosen
  2.	A puzzle piece is chosen for that location, based on possible limitations of the adjoining pieces
  3.	Its orientation is set based on existing adjoining pieces.
  4.	Steps 8.1, 8.2 & 8.3 are repeated until there are no unallocated spaces.

## Storage:

By using a "deterministic random number generator" you only need to store very limited state. That state augments the initial seed to generate reproducible, dynamic, random puzzles
Storage phase object:

``` json
{
  seed: str,
  counter: int,
  rectangularity: int [0 -10],
  render_modes: {
    linnea: int [0 - 10],
    adjacent: int [0 - 10],
    random: int [0 - 10]
  },
  shapes: {
    tangles: int [0 - 10],
    square: int [0 - 10],
    hexagon: int [0 - 10],
    octagon: int [0 - 10]
  }
}
```

## Deterministic Random Numbers
Need to find a "deterministic random number generator"

### References:
*	[@mathiasbynens mathiasbynens/deterministic-math-random.js](https://gist.github.com/mathiasbynens/5670917)
*	[davidbau/seedrandom](https://github.com/davidbau/seedrandom) [seedrandom.js](http://davidbau.com/encode/seedrandom.js)
*	[Javascript hash functions to convert string into integer hash.](http://erlycoder.com/49/javascript-hash-functions-to-convert-string-into-integer-hash-)
*	[Javascript Hashing Functions - Source Code](http://pmav.eu/stuff/javascript-hashing-functions/source.html)
*	[GRC's Ultra High Entropy Pseudo Random Number Generator](https://www.grc.com/otg/uheprng.htm)
*	[Perfect Passwords](https://www.grc.com/passwords.htm)
