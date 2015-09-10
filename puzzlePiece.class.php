<?php

$here = dirname(__FILE__).'/';
require_once($here.'puzzle.interfaces.php');
require_once($here.'puzzlePieceMirror.singleton.class.php');



class puzzlePiece implements puzzlePieceInterface
{
	protected $orientation = 0;

	protected $bridges = array();
	protected $bridgeCount = 0;

	protected $faceCount = 0;

	protected $shape = '';

	protected $code = '';

	protected $oppositeFaces = array();

	protected $mirrored = false;
	protected $mirrorObj = null;

	public function __construct( puzzlePiecePattern $piece , puzzlePieceMirror $mirror ) {
		$this->bridges = $piece->getBridges();
		$this->bridgeCount = $piece->getBridgeCount();
		$this->faceCount = $piece->getFaceCount();
		$this->code = $piece->getCode();
		$this->mirrored = $piece->isMirrored();
		$this->shape = $piece->getShape();
		$this->mirrorObje = $mirror;

		$half = $this->faceCount / 2;
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $a < $half ) {
				$b = $a + $half;
			} else {
				$b = $half - $a;
			}
			$this->oppositeFaces[$a] = $b;
		}
	}

	public function getBridges() { return $this->bridges; }

	public function getCode() { return $this->code; }

	public function getID() { return substr($this->shape,0,3).$this->bridgeCount.$this->code; }

	public function getPieceType() { return get_class($this); }

	public function getShape() { return $this->shape; }

	public function getOppositeFace($face) {
		if( is_int($face) && isset($this->oppositeFaces[$face]) ) {
			return $this->oppositeFaces[$face];
		} else {
			if( !is_int($face) ) {
				$suffix = gettype($face).' given.';
			} else {
				$suffix = get_class($this).'::$oppositeFaces['.$face.'] is undefined.';
			}
			throw new exception(get_class($this).'::getOppositeFaces() expects parameter $faces to be an integer between 0 and '.($this->faceCount - 1 ).'. '.$suffix);
		}
	}

	public function getOrientation() { return $this->orientation; }

	public function hasBridge( $face ) {
		if( is_int($face) && $face >= 0 && $face <= $this->faceCount ) {
			return $this->bridges[$face];
		} else {
			if( is_int($face) ) {
				$suffix = $face;
			} else {
				$suffix = gettype($face);
			}
			throw new exception(get_class($this).'::hasBridge() expects parameter $face to be an integer between 0 and '.$this->faceCount.'. '.$suffix.' given.');
		}
	}

	public function rotate( $steps = 1 ) {
		$end = $this->faceCount - 1;
		if( is_int($steps) && $steps > 0 ) {
			for( $a = 0 ; $a < $steps ; $a += 1 ) {
				$this->incrementOrientation();
				$old = array_pop($this->bridges);
				array_unshift( $this->bridges , $old );
			}
		}
		return $this->orientation;
	}

	public function rotateBack( $steps = 1 ) {
		if( is_int($steps) && $steps > 0 ) {
			for( $a = 0 ; $a < $steps ; $a += 1 ) {
				if( $this->orientation === 0 ) {
					$this->orientation = $this->faceCount - 1;
				} else {
					$this->orientation -= 1;
				}
				$old = array_shift($this->bridges);
				$this->bridges[] = $old;
			}
		}
		return $this->orientation;
	}

	public function rotate180() {
		$half = $this->faceCount / 2;
		if( is_int($half) ) {
			for( $a = 0 ; $a < $half ; $a += 1 ) {
				$this->incrementOrientation();
				$old = array_pop($input);
				array_unshift( $input , $old );
			}
			return true;
		}
		return false;
	}

	public function mirrorH() {
		$this->bridges = $this->mirrorObj->mirrorH($this->bridges);
	}

	public function mirrorV() {
		$this->bridges = $this->mirrorObj->mirrorY($this->bridges);
	}

// END: public functions
// ======================================================++
// START: protected functions

	protected function incrementOrientation() {
		if( $this->orientation === $this->faceCount - 1 ) {
			$this->orientation = 0;
		} else {
			$this->orientation += 1;
		}
	}

}
