// http://stackoverflow.com/questions/4777522/javascript-inheritance-and-method-overriding
// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply
// http://phrogz.net/js/classes/OOPinJS2.html

function puzzleGameHexagon() {

	var bridgePatterns = [
			{ "bridgeCount": "0", "key":  "", "bridges": "000000", "mirrorable": false },
			{ "bridgeCount": "1", "key":  "", "bridges": "000001", "mirrorable": false },
			{ "bridgeCount": "2", "key": "a", "bridges": "000011", "mirrorable": false },
			{ "bridgeCount": "2", "key": "b", "bridges": "000101", "mirrorable": false },
			{ "bridgeCount": "2", "key": "c", "bridges": "001001", "mirrorable": false },
			{ "bridgeCount": "3", "key": "a", "bridges": "000111", "mirrorable": false },
			{ "bridgeCount": "3", "key": "b", "bridges": "001011", "mirrorable": true  },
			{ "bridgeCount": "3", "key": "c", "bridges": "010101", "mirrorable": false },
			{ "bridgeCount": "4", "key": "a", "bridges": "001111", "mirrorable": false },
			{ "bridgeCount": "4", "key": "b", "bridges": "010111", "mirrorable": false },
			{ "bridgeCount": "4", "key": "c", "bridges": "011011", "mirrorable": false },
			{ "bridgeCount": "5", "key":  "", "bridges": "011111", "mirrorable": false },
			{ "bridgeCount": "6", "key":  "", "bridges": "111111", "mirrorable": false }
		],
		mirrorH = [[1,5],[2,4]],
		mirrorV = [[0,3],[1,2],[4,5]],
		faceCount = 6,
		shape = 'hexagon';

	function generatePuzzle() {

	}
}

