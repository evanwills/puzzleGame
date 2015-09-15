<?php

require_once(dirname(__FILE__).'/puzzle.interfaces.php');

class blankPuzzlePiece implements puzzlePieceInterface
{
	protected $bridges = array();

	protected $faceCount = 3;

	protected $shape = '';
	protected $bridgeCount = '0';

	static private $singleton = array();

	private function __construct( $shape , $faces ) {
		if( $shape = self::shapeIsValid($shape) ) {
			$this->shape = $shape;
		}
		if( $faces !== self::facesIsValid($faces) ) {
			$this->faceCount = $faces;
		}
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			$this->bridges[] = false;
		}
	}

	static public function getPiece( $shape , $faces ) {
		$pieceType = get_class($this);
		if( $shape = self::shapeIsValid($shape) ) {
			if( !isset(self::$singleton[$shape]) ) {
				if( $faces = self::facesIsValid($faces) ) {
					$pieceType = get_class(self);
					self::$singleton[$shape] = new $pieceType($shape , $faces );
				} else {
					if( !is_int($faces) ) {
						$suffix = gettype($faces);
					} else {
						$suffix = $faces;
					}
					throw new exception($pieceType.'::getBlankPiece() expects second parameter $faces to be an integer greater than 2. '.$suffix.' given');
				}
			}
			return self::$singleton[$shape];
		} else {
			if( !is_string($shape)) {
				$suffix = gettype($shape);
			} else {
				$suffix = $shape;
			}
			throw new exception($pieceType.'::getBlankPiece() expects first parameter $shape to be a a valid shape name. '.$suffix.' given');
		}
	}

	public function getBridges() { return $this->bridges; }
	public function getCode() { return $this->code; }

	public function getID() { return substr($this->shape,0,3).'0'; }

	public function getOppositeFace( $face , $faceCount ) {
		$originalFace = $face;
		if( is_int($face) && is_int($faceCount) ) {
			if( $this->faceCount !== $faceCount ) {
				if( ($this->faceCount / 2) === $faceCount) {
					$face *= 2;
				} elseif( ($this->faceCount * 2) === $faceCount) {
					$face /= 2;
				} else {
					throw new exception(get_class($this).'::getOppositeFace() cannot handle neighbours with '.$faceCount.' faces');
				}
			}
			if( $face < $this->faceCount) {
				$half = floor($this->faceCount / 2);
				if( $face > $half ) {
					$face -= $half;
				} elseif( $face < $half ) {
					$face += $half;
				} else {
					throw new exception(get_class($this).'::getOppositeFace() cannot find the neighbour for '.$originalFace);
				}
				return $face;
			} else {
				throw new exception(get_class($this).'::getOppositeFace() expects first parameter $face to be between 0 and '.$this->faceCount.'. '.$face.' (translated from '.$originalFace.') given.');
			}
		} else {
			$arr = array( 'first' => 'face' , 'second' => 'faceCount' );
			foreach( $arr = $key => $value ) {
				if( !is_int($$value) ) {
					$which = $key;
					$var = $value;
					$suffix = gettype($$value);
				}
			}
			throw new exception(get_class($this).'::getOppositeFace() expects '.$which.' parameter $'.$var.' to be an integer. '.$suffix.' given.');
	}

	public function getOrientation() { return 0; }
	public function getPieceType() { return get_class($this); }
	public function getShape() { return $this->shape; }

	public function copyMe() { return $this; }

	public function connectToNeighbours( $neighbourBridges ) { return true; }

	public function hasBridge( $face , $faceCount ) { return false; }

	public function rotate( $steps = 1 ) { return 0; }
	public function rotateBack( $steps = 1 ) { return 0; }
	public function rotate180() { return 0; }

	public function mirrorH() {}
	public function mirrorV() {}

// END: public methods
// ==============================================
// START: protected methods

	static protected function shapeIsValid($shape) {
		if( is_string($shape) ) {
			$shape = trim(strtolower($shape));
			if( strlen($shape) > 4 && ( $shape === 'triangle' || $shape === 'square' || substr($shape,-4,4)  === 'agon' ) ) {
				return $shape;
			}
		}
		return false;
	}

	static protected function facesIsValid($faces) {
		if( is_int($faces) && $faces > 2 ) {
			return true;
		}
		return false;
	}
}

class nullPuzzlePiece extends blankPuzzlePiece  {

	static private $singleton = array();
	protected $code = 'N';

	public function hasBridge( $face ) { return null; }
	static public function getBridgePatterns() {
		$output = array( array( 'key' => 'N' , 'bridgeCount' => 0 , 'bridges' => array() , 'mirror' => false ) );
	}
}
