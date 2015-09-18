<?php


/**
 * @interface puzzleGame abstract factory method
 *
 */
interface puzzleGameInterface
{
	public function __construct( $X , $Y , $mode );

	public function getX();

	public function getY();

	public function getMode();

	public function getPieces();
}



/**
 * @class puzzlePiece stores:
 * 	-	the number of bridges a piece has;
 *  -	the pattern the bridges are aranged in and the (clockwise)
 *  	steps from north the piece is orientated
 *   	(e.g.	square piece whose north face has been rotated to the
 *    			west would have an orientation of 3 where North is 0)
 */
interface puzzlePieceInterface
{
	/**
	 * @function getBridges() returns an array of where each face of
	 * the piece is represented by a boolean in the array. True if
	 * there is a bridge, false otherwise
	 *
	 * @return array
	 */
	public function getBridges();

	/**
	 * @function getCode() returns a single alphabetical character
	 * string (or empty string) identifying the piece's bridge patter
	 * for the bridge count.
	 *
	 * If there is only one possible pattern for a given bridge count
	 * the string will be empty. If the pattern is a mirror of the
	 * standard pattern the character will be upper case.
	 */
	public function getCode();

	/**
	 * @function getFaceCount() returns the number of faces this
	 * piece has
	 *
	 * @return integer the number of faces this piece has
	 */
	public function getFaceCount();

	/**
	 * @function getID() returns the CSS class name of the piece
	 *
	 * @return string CSS class name of the piece with the
	 *		following pattern:
	 *			1.	first three characters of the shape name,
	 *			2.	the number of bridges
	 *			3.	code identifying the pattern for that bridge
	 *				count (if any)
	 */
	public function getID();

	/**
	 * @function getOppositeFace() returns the appropriate face number
	 * given the requested face and the faceCount of the neighbour
	 * making the request
	 *
	 * @param integer $face the number of the face the neighbour wants
	 *		to get info about
	 *
	 * @param integer $faceCount the number of faces the neighbour has
	 *
	 * @return integer the face number of this piece that is adjacent
	 *		to the face of the requested neighbour
	 */
	public function getOppositeFace( $face , $faceCount );

	/**
	 * @function getOrientation() returns the number of steps from
	 * north the piece has been rotated
	 *
	 * @return integer
	 */
	public function getOrientation();

	/**
	 * @function getPieceType() returns the class name of the piece
	 * 		currently:	'puzzlePiece',
	 *					'blankPuzzlePiece' or
	 *					'nullPuzzlePiece'
	 */
	public function getPieceType();

	/**
	 * @function getShape() returns the string name of the shape of
	 * this piece
	 *
	 * @return string name of shape this puzzle represents
	 *		currently:	'hexagon',
	 *					'octagon',
	 *					'square' or
	 *					'triangle'
	 */
	public function getShape();


	/**
	 * @function hasBridge() whether there is a bridge on the face
	 * adjacent to the requested face of it's direct neighbour given
	 * the requesting neighbour's face number and and faceCount
	 *
	 * @param integer $face the number of the face the neighbour wants
	 *		to get info about
	 *
	 * @param integer $faceCount the number of faces the neighbour has
	 *
	 * @return boolean TRUE if face of this piece that is adjacent
	 *		to the face of the requested neighbour has a bridge.
	 *		FALSE otherwise
	 */
	public function hasBridge( $face , $faceCount  );

	/**
	 * @function rotate() changes the orientation of the piece by the
	 * specified number of steps.
	 *
	 * Rotation is done by moving faces from the end of the bridges
	 * array to the begining. The orientation is also updated.
	 *
	 * @return integer the integer of the current orientation of the
	 *		piece
	 */
	public function rotate( $steps = 1 );


	/**
	 * @function rotate180() changes the orientation of the piece by
	 * half the possible number of steps.
	 *
	 * Rotation is done by moving faces from the end of the bridges
	 * array to the begining. The orientation is also updated.
	 *
	 * @return integer the integer of the current orientation of the
	 *		piece
	 */
	public function rotate180();


	/**
	 * @function rotate() changes the orientation of the piece by the
	 * specified number of steps.
	 *
	 * Rotation is done by moving faces from the begining of the
	 * bridges array to the end. The orientation is also updated.
	 *
	 * @return integer the integer of the current orientation of the
	 *		piece
	 */
	public function rotateBack($steps = 1 );

//	public function copyMe();

	/**
	 * @function mirrorH() Mirrors the bridges of the piece along the
	 * North/South axsis
	 */
	public function mirrorH();
	/**
	 * @function mirrorV() Mirrors the bridges of the piece along the
	 * East/West axsis
	 */

	public function mirrorV();
}



/**
 *
 */
interface puzzlePieceObserverInterface
{
	/**
	 * @function isConnected() whether or not the piece contained
	 * within is connected to its neighbours
	 *
	 * @return boolean TRUE if all bridges are connected to its
	 *		neighbours FALSE otherwise
	 */
	public function isConnected();

	public function connectToNeighbours();

	public function setPuzzlePiece( puzzlePiece $puzzle );

	public function getRequiredBridges();
}
