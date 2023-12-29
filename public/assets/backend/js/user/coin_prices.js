




var liveprice = {
    "async": true,
    "scroosDomain": true,
    "url": "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Cdogecoin%2Cuniswap%2Ccardano%2Ctron%2Clitecoin%2Cdai&vs_currencies=usd&include_24hr_vol=true&include_24hr_change=true",

    "method": "GET",
    "headers": {}
}

$.ajax(liveprice).done(function (response){


	var list = document.getElementsByClassName('bitcoin');
	var list2 = document.getElementsByClassName('bitcoin-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.bitcoin.usd.toFixed(2)	;
		list2[n].innerHTML=response.bitcoin.usd_24h_change.toFixed(2)+'%'	;
	}


	var list = document.getElementsByClassName('litecoin');
	var list2 = document.getElementsByClassName('litecoin-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.litecoin.usd.toFixed(2);
		list2[n].innerHTML=response.litecoin.usd_24h_change.toFixed(2)+'%';
	}

	var list = document.getElementsByClassName('ethereum');
	var list2 = document.getElementsByClassName('ethereum-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.ethereum.usd.toFixed(2);
		list2[n].innerHTML=response.ethereum.usd_24h_change.toFixed(2)+'%'	;
	}


	var list = document.getElementsByClassName('tether');
	var list2 = document.getElementsByClassName('tether-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.tether.usd.toFixed(2);
		list2[n].innerHTML=response.tether.usd_24h_change.toFixed(2)+'%'	;
	}
    var list = document.getElementsByClassName('tron');
	var list2 = document.getElementsByClassName('tron-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.tron.usd.toFixed(2);
		list2[n].innerHTML=response.tron.usd_24h_change.toFixed(2)+'%'	;
	}


    var list = document.getElementsByClassName('cardano');
	var list2 = document.getElementsByClassName('cardano-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.cardano.usd.toFixed(2);
		list2[n].innerHTML=response.cardano.usd_24h_change.toFixed(2)+'%'	;
	}


    var list = document.getElementsByClassName('dai');
	var list2 = document.getElementsByClassName('dai-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.dai.usd.toFixed(2);
		list2[n].innerHTML=response.dai.usd_24h_change.toFixed(2)+'%'	;
	}


    var list = document.getElementsByClassName('dogecoin');
	var list2 = document.getElementsByClassName('dogecoin-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.dogecoin.usd.toFixed(2);
		list2[n].innerHTML=response.dogecoin.usd_24h_change.toFixed(2)+'%'	;
	}


    var list = document.getElementsByClassName('uniswap');
	var list2 = document.getElementsByClassName('uniswap-change');
	var n;
	for (n = 0; n < list.length; ++n) {
		list[n].innerHTML='$'+response.uniswap.usd.toFixed(2);
		list2[n].innerHTML=response.uniswap.usd_24h_change.toFixed(2)+'%'	;
	}



});
