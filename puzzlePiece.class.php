<?php

require_once(dirname(__FILE__).'/puzzleGame.interface.php');
require_once(dirname(__FILE__).'/puzzleGame.abstract.class.php');



class puzzlePiece implements puzzlePieceInterface
{
	protected $orientation = 0;

	protected $bridges = array();

	protected $faceCount = 0;

	protected $shape = '';

	protected $code = '';

	protected $mirrored = false;

	private function __construct( puzzlePiecePattern $piece ) {
		$this->bridges = $piece->getBridges();
		$this->faceCount = $piece->getFaceCount();
		$this->shape = $piece->getShape();
		$this->code = $piece->getCode();
		$this->mirrored = $piece->isMirrored();
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


	public function getOrientation() {
		return $this->orientation;
	}


	public function getShape() {
		return $this->shape;
	}

	public function getCode() {
		return $this->code;
	}

	public function rotate( $steps = 1 ) {
		$end = $this->faceCount - 1;
		if( is_int($steps) && $steps > 0 ) {
			for( $a = 0 ; $a < $steps ; $a += 1 ) {
				if( $this->orientation === $end ) {
					$this->orientation = 0;
				} else {
					$this->orientation += 1;
				}
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

	public function getBridges() {
		return $this->bridges;
	}
}
