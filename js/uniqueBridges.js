function octagonBridges() {
	return [
		{ "bridgeCount": "0", "key":  "", "bridges": "00000000", "mirrorable": false },
		{ "bridgeCount": "1", "key":  "", "bridges": "00000001", "mirrorable": false },
		{ "bridgeCount": "2", "key": "a", "bridges": "00000011", "mirrorable": false },
		{ "bridgeCount": "2", "key": "b", "bridges": "00000101", "mirrorable": false },
		{ "bridgeCount": "2", "key": "c", "bridges": "00001001", "mirrorable": false },
		{ "bridgeCount": "2", "key": "d", "bridges": "00010001", "mirrorable": false },
		{ "bridgeCount": "3", "key": "a", "bridges": "00000111", "mirrorable": false },
		{ "bridgeCount": "3", "key": "b", "bridges": "00001011", "mirrorable":  true },
		{ "bridgeCount": "3", "key": "c", "bridges": "00010011", "mirrorable":  true },
		{ "bridgeCount": "3", "key": "d", "bridges": "00010101", "mirrorable": false },
		{ "bridgeCount": "3", "key": "e", "bridges": "00100101", "mirrorable": false },
		{ "bridgeCount": "4", "key": "a", "bridges": "00001111", "mirrorable": false },
		{ "bridgeCount": "4", "key": "b", "bridges": "00010111", "mirrorable":  true },
		{ "bridgeCount": "4", "key": "c", "bridges": "00011011", "mirrorable": false },
		{ "bridgeCount": "4", "key": "d", "bridges": "00100111", "mirrorable": false },
		{ "bridgeCount": "4", "key": "e", "bridges": "00101011", "mirrorable":  true },
		{ "bridgeCount": "4", "key": "f", "bridges": "00101101", "mirrorable": false },
		{ "bridgeCount": "4", "key": "g", "bridges": "00110011", "mirrorable": false },
		{ "bridgeCount": "4", "key": "h", "bridges": "01010101", "mirrorable": false },
		{ "bridgeCount": "5", "key": "a", "bridges": "00011111", "mirrorable": false },
		{ "bridgeCount": "5", "key": "b", "bridges": "00101111", "mirrorable":  true },
		{ "bridgeCount": "5", "key": "c", "bridges": "00110111", "mirrorable":  true },
		{ "bridgeCount": "5", "key": "d", "bridges": "01010111", "mirrorable": false },
		{ "bridgeCount": "5", "key": "e", "bridges": "01011011", "mirrorable": false },
		{ "bridgeCount": "6", "key": "a", "bridges": "00111111", "mirrorable": false },
		{ "bridgeCount": "6", "key": "b", "bridges": "01011111", "mirrorable": false },
		{ "bridgeCount": "6", "key": "c", "bridges": "01101111", "mirrorable": false },
		{ "bridgeCount": "6", "key": "d", "bridges": "01110111", "mirrorable": false },
		{ "bridgeCount": "7", "key":  "", "bridges": "01111111", "mirrorable": false },
		{ "bridgeCount": "8", "key":  "", "bridges": "11111111", "mirrorable": false }
	];
}


function hexagonBridges() {
     return [
		{ "bridgeCount": "0", "key":  "", "bridges": "000000", "mirrorable": false },
		{ "bridgeCount": "1", "key":  "", "bridges": "000001", "mirrorable": false },
		{ "bridgeCount": "2", "key": "a", "bridges": "000011", "mirrorable": false },
		{ "bridgeCount": "2", "key": "b", "bridges": "000101", "mirrorable": false },
		{ "bridgeCount": "2", "key": "c", "bridges": "001001", "mirrorable": false },
		{ "bridgeCount": "3", "key": "a", "bridges": "000111", "mirrorable": false },
		{ "bridgeCount": "3", "key": "b", "bridges": "001011", "mirrorable":  true },
		{ "bridgeCount": "3", "key": "c", "bridges": "010101", "mirrorable": false },
		{ "bridgeCount": "4", "key": "a", "bridges": "001111", "mirrorable": false },
		{ "bridgeCount": "4", "key": "b", "bridges": "010111", "mirrorable": false },
		{ "bridgeCount": "4", "key": "c", "bridges": "011011", "mirrorable": false },
		{ "bridgeCount": "5", "key":  "", "bridges": "011111", "mirrorable": false },
		{ "bridgeCount": "6", "key":  "", "bridges": "111111", "mirrorable": false }
	];
}

function squareBridges() {
     return[
		{ "bridgeCount": "0", "key":  "", "bridges": "0000", "mirrorable": false },
		{ "bridgeCount": "1", "key":  "", "bridges": "0001", "mirrorable": false },
		{ "bridgeCount": "2", "key": "a", "bridges": "0011", "mirrorable": false },
		{ "bridgeCount": "2", "key": "b", "bridges": "0101", "mirrorable": false },
		{ "bridgeCount": "3", "key":  "", "bridges": "0111", "mirrorable": false },
		{ "bridgeCount": "4", "key":  "", "bridges": "1111", "mirrorable": false }
	];
}

