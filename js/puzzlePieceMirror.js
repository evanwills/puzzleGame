
function PuzzlePieceMirror(inputMirrorX, inputMirrorY) {
	'use strict';
//	static private $singletons = array();

	var mirrorXfaces = [],
		mirrorYfaces = [],

		a = 0,
		suffix = '';

	static public function getMirror( inputFaces , inputMirrorX , inputMirrorY ) {
		suffix = '';
		if (inputFaces === parseInt(inputFaces, 10) || inputFaces < 2 ) {
			if (inputFaces === parseInt(inputFaces, 10)) {
				suffix = typeof (inputFaces);
			} else {
				suffix = inputFaces;
			}
			throw 'PuzzlePieceMirror.getMirror() expects first parameter $faces to be an integer greater than 1 ' + suffix + ' given.');
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
					throw new exception('mirrorPuzzlePiece::getMirror() expects '.$which.' parameter $mirror'.axis[a].' to be an array with at least one child array.');
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

	this.mirrorX = function (bridges) {
		return $this->mirrorInner(bridges, mirrorXfaces);
	};

	this.mirrorY = function (bridges) {
		return mirrorInner(bridges, mirrorXfaces);
	};



	function mirrorInner(bridges, swapsies) {
		var tmp0 = null,
			tmp1 = null,
			first = null,
			second = null;
		if (!Array.prototype.isPrototypeOf(bridges)) {
			throw new exception('');
		}
		for (a = 0; a < swapsies.length; a += 1) {
			tmp0 = swapsies[a][0];
			tmp1 = swapsies[a][1];
			if (bridges[tmp0] === undefined || bridges[tmp1] === undefined) {
				throw new exception('');
			}
			first = bridges[tmp0];
			second = bridges[tmp1];
			bridges[tmp0] = second;
			bridges[tmp1] = first;
		}
		return $bridges;
	}

}
