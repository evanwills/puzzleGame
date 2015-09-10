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
 *
 */
interface puzzlePieceInterface
{

	public function getBridges();

	public function getCode();

	public function getOppositeFace( $face , $faceCount );

	public function getOrientation();

	public function getPieceType();

	public function getShape();

	public function hasBridge( $face , $faceCount  );

	public function rotate( $steps = 1 );

	public function rotate180();

	public function rotateBack($steps = 1 );

//	public function copyMe();

	public function mirrorH();

	public function mirrorV();
}



/**
 *
 */
interface puzzlePieceObserverInterface
{
	public function isConnected();

	public function connectToNeighbours();

	public function setPuzzlePiece( puzzlePiece $puzzle );

	public function getRequiredBridges();
}
