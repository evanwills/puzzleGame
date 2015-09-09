<?php

$here = dirname(__FILE__).'/';
require_once($here.'/puzzle.interface.php');
require_once($here.'/puzzlePieceMirror.class.php');



class puzzlePiece implements puzzlePieceInterface
{
	protected $orientation = 0;

	protected $bridges = array();
	protected $bridgeCount = 0;

	protected $faceCount = 0;

	protected $shape = '';

	protected $code = '';

	protected $mirrored = false;
	protected $mirrorObj = null;

	public function __construct( puzzlePiecePattern $piece , puzzlePieceMirror $mirror ) {
		$this->bridges = $piece->getBridges();
		$this->bridgeCount = $piece->getBridgeCount();
		$this->code = $piece->getCode();
		$this->faceCount = $piece->getFaceCount();
		$this->mirrored = $piece->isMirrored();
		$this->shape = $piece->getShape();
		$this->mirrorObje = $mirror;
	}

	public function getBridges() { return $this->bridges; }

	public function getCode() { return $this->code; }

	public function getOrientation() { return $this->orientation; }

	public function getPieceType() { return get_class($this); }

	public function getShape() { return $this->shape; }

	public function connectToNeighbours( $neighbourBridges ) {
		$suffix = '';
		if( !is_array($neighbourBridges) ) {
			$suffix = gettype($neighbourBridges);

		} elseif( count($neighbourBridges) !== $this->faceCount ) {
			$suffix = 'array with '.count($neighbourBridges).' items';
		}
		if( $suffix !== '' ) {
			throw new exception('puzzlePiece::connectToNeighbours() expects parameter $neighbourBridges to be an array with '.$this->faceCount.' items. '.$suffix.' given');
		}

		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( !is_bool($neighbourBridges[$a]) && !is_null($neighbourBridges[$a]) ) {
				throw new exception('puzzlePiece::connectToNeighbours() expectes parameter $neighbourBridges['.$a.'] to be boolean or NULL. '.gettype($neighbourBridges[$a]));
			}
		}

		$output = false;
		$limit = $this->faceCount;
		while( $output === false && $limit > 0 ) {
			$unbridged = $this->bridgeCount;
			for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
				if( $neighbourBridges[$a] === $this->bridges[$a] && $neighbourBridges[$a] !== false ) {
					$unbridged -= 1;
				}
			}
			if( $unbridged < 1 ) {
				return true;
			}
			$this->rotate();
			$limit -= 1;
		}

		throw new exception('puzzlePiece::connectToNeighbours() cannot connect bridges to neighbours.');
	}

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
