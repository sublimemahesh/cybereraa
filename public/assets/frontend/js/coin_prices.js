




var liveprice = {
    "async": true,
    "scroosDomain": true,
    "url": "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Clitecoin%2Cethereum%2Ctether&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true",

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
		
	   

});
