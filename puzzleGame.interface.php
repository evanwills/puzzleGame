<?php


/**
 * @interface puzzleGame abstract factory method
 *
 */
interface puzzleGame
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
interface puzzlePiece
{
	public function isConnected();

	public function hasBridge( $face );

	public function getOrientation();

	public function rotate();

	public function rotateBack();

	public function getShape();

	public function getCode();

	public function copyMe();

	static public function getBridgePatterns();
}



/**
 *
 */
interface puzzlePieceVisitorInterface implements puzzlePiece
{
	public function setPuzzlePiece( puzzlePiece $puzzle );
}
