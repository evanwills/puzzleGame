<?php

class puzzlePiecePattern {
	protected $facesShape = array( 3 => 'triangle' , 4 => 'square' , 5 => 'pentagon' , 6 => 'hexagon' , 7 => 'septagon' , 8 'octagon' , 9 => 'nonagon' , 10 => 'decagon' );
	protected $maxSides = 10;
	protected $mirrorable = false;
	protected $bridges = array();
	protected $bridgeCount = 0;
	protected $shape = '';
	protected $faceCount = 0;
	protected $code = '';
	protected $mirrorObj = null;
	protected $mirrored = false;

	public function construct( $code , $shape , $mirrorable , $bridges ) {

		$suffix = '';
		$msg = 'puzzlePiecePattern::__construct() expects '.;

		// ======================================
		if( !is_string($shape) ) {
			$suffix = gettype($shape);
		}

		$shape = trim(strtolower($shape));
		if( strlen($shape) > 4 && ( $shape === 'triangle' || $shape === 'square' || substr($shape,-4,4)  === 'agon' ) ) {
			$this->shape = $shape;
		} else {
			$suffix = '"'.$shape.'"';
		}
		if( $suffix !== '' ) {
			throw new exception($msg.'second parameter $shape to be a valid shape name. '.$suffix.' given');
		}

		// ======================================

		if( !is_array($bridges) ) {
			$suffix = gettype($bridges);
		} elseif( empty($bridges) ) {
			$suffix = 'empty array';
		} elseif( count($bridges) < 3 ) {
			$suffix = 'array with less than 3 items'
		}
		if( $suffix !== '' ) {
			throw new exception($msg.'fourth parameter $bridges to be an array with between 3 and '.$this->maxSides.'. '.$suffix.' given');
		}
		$this->faceCount = count($bridges);
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( is_bool($) ) {
				$this->bridges[] = $bridges[$a];
				if( $bridges[$a] === true ) {
					$this->bridgeCount += 1;
				}
			} else {
				throw new exception($msg.'fourth parameter $bridges['.$a.'] must be boolean. '.gettype($bridges[$a]).' given');
			}
		}

		// ======================================

		if( !is_string($code) ) {
			$suffix = gettype($code);
		} elseif( !preg_match('`[a-z]?`i') ) {
			$suffix = '"'.$code.'"';
		}
		if( $suffix !== '' ) {
			throw new exception($msg.'first parameter $code must be a single alphabetical character string. '.$suffix.' given');
		}
		$this->code = $this->faceCount.$code;

		// ======================================

		 if( is_bool($mirrorable) ) {
			 $this->mirrorable = $mirrorable;
		 } else {
			 throw new exception($msg.'third parameter $mirrorable must be boolean. '.gettype($mirrorable).' given');
		 }

		// ======================================

		$this->shape = $this->facesShape[$this->faceCount];
	}

	public function isMirrorable() { return $this->mirrorable; }
	public function getShape() { return $this->shape; }
	public function getCode() { return $this->code; }
	public function getFaceCount() { return $this->faceCount; }
	public function getBridges() { return $this->bridges; }
	public function getBridgeCount() { return $this->bridgeCount; }
	public function isMirrored() { return $this->mirrored; }

	public function getMirror)() {
		if( $this->mirrorObj === null ) {
			$this->mirrorObj => $this->clone();
		}
		return $this->mirrorObj;
	}

	public function isUsable($neighbours) {
		$suffix = '';
		if( !is_array($neighbours) ) {
			$suffix = gettype($neighbours);
		} elseif( count($neighbours) !== $this->faceCount ) {
			$suffix = count($neighbours).' neighbours';
		}
		if( $suffix !== '' ) {
			throw new exception('puzzlePiecePattern::isUsable expects parameter $neighbours to be an array with '.$this->faceCount.' items. '.$suffix.' given');
		}
		$bridges = $this->bridges;
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $this->isUsableInner($neighbours,$this->bridges) ) {
				return $this;
			}
			$bridges = $this->rotate($bridges);
		}
		if( $this->mirroable === true ) {
			$bridges = $this->mirrorBridges();
			for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
				if( $this->isUsableInner($neighbours,$bridges) ) {
					if( $this->mirrorObj === null ) {
						$this->mirrorObj => $this->clone();
					}
					return $this->mirrorObj;
				}
				$bridges = $this->rotate($bridges);
			}
		}
		return false;
	}

	public function mirrorBridges() {
		if( $this->mirrorable === true ) {
			$output = array();
			for( $a = $this->faceCount - 1 ; $a >= 0 ; $a -= 1 ) {
				$output[] = $this->bridges[$a];
			}
			return $output;
		}
		return $this->bridges;
	}

	protected function __clone() {
		if( preg_match('`[a-z]`',$this->code) ) {
			$this->code = strtoupper($this->code);
		} else {
			$this->code = strtolower($this->code);
		}
		$this->bridges = $this->getMirror();
		$this->mirrored = true;
	}


	protected function isUsableInner( $neighbours , $bridges ) {

		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $neighbours[$a] !== $bridges[$a] && $neighbours[$a] !== null ) {
				return false;
			}
			// $neighbours[$a] === $bridges[$a] || $neighbours[$a] === null
		}
		return true;
	}


	protected function rotate( $bridges ) {
		$old = array_pop($bridges);
		array_unshift( $bridges , $old );
		return $bridges
	}
}
