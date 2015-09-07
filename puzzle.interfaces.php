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

	public function hasBridge( $face );

	public function getOrientation();

	public function rotate( $steps = 1 );

	public function rotateBack($steps = 1 );

	public function getShape();

	public function getCode();

	public function copyMe();

	static public function getBridgePatterns();
}



/**
 *
 */
interface puzzlePieceObserverInterface implements puzzlePieceInterface
{
	public function setPuzzlePiece( puzzlePiece $puzzle );

	public function getRequiredBridges();
}
