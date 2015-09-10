<?php

class puzzlePieceMirror {
	static private $singletons = array();

	private $mirrorX = array();
	private $mirrorY = array();

	private function __construct( $mirrorX , $mirrorY ) {

	}

	static public function getMirror( $faces , $mirrorX , $mirrorY ) {
		$suffix = '';
		if( !is_int($faces) || $faces < 2 ) {
			if( !is_int($faces) ) {
				$suffix = gettype($faces);
			} else {
				$suffix = $faces;
			}
			throw new exception('mirrorPuzzlePiece::getMirror() expects first parameter $faces to be an integer greater than 1 '.$suffix.' given.');
		}
		if( !isset($this->singletons[$faces]) ) {
			$axis = array('X','Y');
			$which = 'second';
			for( $a = 0 ; $a < 2 ; $a += 1 ) {
				$var = 'mirror'.$axis[$a];
				$suffix = '';
				if( !is_array($$var) ) {
					$suffix = gettype($$var);
				} elseif( count($$var) === 0 ) {
					$suffix = $$var;
				}
				if( $suffix !== '' ) {
					throw new exception('mirrorPuzzlePiece::getMirror() expects '.$which.' parameter $mirror'.$axis[$a].' to be an array with at least one child array.');
				}
				for( $b = 0 ; $b < count($$var) ; $b += 1 ) {
					$tmp = $$var;
					$item = $tmp[$b];
					if( !is_array($item) ) {
						$suffix = gettype($item).' given';
					} elseif( count($item) !== 2 ) {
						$x = count($item);
						$suffix = 'array has '.$x.' item';
						if( $x > 1 ) {
							$suffix .= 's';
						}
					}
					if( $suffix !== '' ) {
						throw new exception('mirrorPuzzlePiece::getMirror() expects '.$which.' parameter $mirror'.$axis[$a].'['.$b.'] to be an array with at exactly 2 children. '.$suffix);
					}
					for( $c = 0 ; $c < 2 ; $c += 1 ) {
						if( !is_int($item[$c]) ) {
							$suffx = gettype($itme[$c]);
						} elseif( $item[$c] < 0 ) {
							$suffix = $item[$c];
						}
						if( $suffix !== '' ) {
							throw new exception('mirrorPuzzlePiece::getMirror() expects '.$which.' parameter $mirror'.$axis[$a].'['.$b.']['.$c.'] to be an integer equal to or greater than zero. '.$suffix.' given');
						}

					}
				}
				$which = 'third';
			}
			$this->singletons[$faces] = new self( $mirrorX , $mirrorY );
		}
		return $this->singletons[$faces];
	}

	public function mirrorX( $bridges ) {
		return $this->mirrorInner( $bridges, $this->mirrorX );
	}

	public function mirrorY( $bridges ) {
		return $this->mirrorInner( $bridges, $this->mirrorY );
	}



	protected function mirrorInner( $bridges , $swapsies ) {
		if( !is_array($bridges) ) {
			throw new exception('');
		}
		for( $a = 0 ; $a < count($swapsies) ; $a += 1 ) {
			if( !isset($bridges[$swapsies[0]]) || !isset($bridges[$swapsies][1]) ) {
				throw new exception('');
			}
			$first = $bridges[$swapsies[0]];
			$second = $bridges[$swapsies[1]];
			$bridges[$swapsies[0]] = $second;
			$bridges[$swapsies[1]] = $first;
		}
		return $bridges;
	}

}
