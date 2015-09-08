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
//	public function isConnected();

	public function getBridges()

	public function getCode();

	public function getOrientation();

	public function getPieceType();

	public function getShape();

	public function hasBridge( $face );

	public function rotate( $steps = 1 );

	public function rotateBack($steps = 1 );

	public function rotate180();

	public function copyMe();

	public function mirrorH();

	public function mirrorV();

	public function connectToNeighbours( $neighbourBridges );
}



/**
 *
 */
interface puzzlePieceObserverInterface implements puzzlePieceInterface
{
	public function setPuzzlePiece( puzzlePiece $puzzle );

	public function getRequiredBridges();
}
