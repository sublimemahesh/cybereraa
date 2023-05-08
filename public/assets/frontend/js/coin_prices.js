

var btc1 = document.getElementsByClassName("bitcoin")[0];
var ltc1 = document.getElementsByClassName("litecoin")[0];
var eth1 = document.getElementsByClassName("ethereum")[0];
var tet1 = document.getElementsByClassName("tether")[0];
var btc2 = document.getElementsByClassName("bitcoin")[1];
var ltc2 = document.getElementsByClassName("litecoin")[1];
var eth2 = document.getElementsByClassName("ethereum")[1];
var tet2 = document.getElementsByClassName("tether")[1];
var btc3 = document.getElementsByClassName("bitcoin")[2];
var ltc3 = document.getElementsByClassName("litecoin")[2];
var eth3 = document.getElementsByClassName("ethereum")[2];
var tet3 = document.getElementsByClassName("tether")[2];


var btc_change1 = document.getElementsByClassName("bitcoin-change")[0];
var btc_change2 = document.getElementsByClassName("bitcoin-change")[1];
var btc_change3 = document.getElementsByClassName("bitcoin-change")[2];

var ltc_change1 = document.getElementsByClassName("litecoin-change")[0];
var ltc_change2 = document.getElementsByClassName("litecoin-change")[1];
var ltc_change3 = document.getElementsByClassName("litecoin-change")[2];

var eth_change1 = document.getElementsByClassName("ethereum-change")[0];
var eth_change2 = document.getElementsByClassName("ethereum-change")[1];
var eth_change3 = document.getElementsByClassName("ethereum-change")[2];

var tet_change1 = document.getElementsByClassName("tether-change")[0];
var tet_change2 = document.getElementsByClassName("tether-change")[1];
var tet_change3 = document.getElementsByClassName("tether-change")[2];


 


var liveprice = {
    "async": true,
    "scroosDomain": true,
    "url": "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Clitecoin%2Cethereum%2Ctether&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true",

    "method": "GET",
    "headers": {}
}

$.ajax(liveprice).done(function (response){
    btc1.innerHTML = '$'+response.bitcoin.usd.toFixed(2);
	ltc1.innerHTML = '$'+response.litecoin.usd.toFixed(2);
    eth1.innerHTML = '$'+response.ethereum.usd.toFixed(2);
    tet1.innerHTML = '$'+response.tether.usd.toFixed(2);
	
	btc2.innerHTML = '$'+response.bitcoin.usd.toFixed(2);
	ltc2.innerHTML = '$'+response.litecoin.usd.toFixed(2);
    eth2.innerHTML = '$'+response.ethereum.usd.toFixed(2);
    tet2.innerHTML = '$'+response.tether.usd.toFixed(2);
	
	btc3.innerHTML = '$'+response.bitcoin.usd.toFixed(2);
	ltc3.innerHTML = '$'+response.litecoin.usd.toFixed(2);
    eth3.innerHTML = '$'+response.ethereum.usd.toFixed(2);
    tet3.innerHTML = '$'+response.tether.usd.toFixed(2);
   
   btc_change1.innerHTML = response.bitcoin.usd_24h_change.toFixed(2)+'%';
   btc_change2.innerHTML = response.bitcoin.usd_24h_change.toFixed(2)+'%';
   btc_change3.innerHTML = response.bitcoin.usd_24h_change.toFixed(2)+'%';
   
   ltc_change1.innerHTML = response.litecoin.usd_24h_change.toFixed(2)+'%';
   ltc_change2.innerHTML = response.litecoin.usd_24h_change.toFixed(2)+'%';
   ltc_change3.innerHTML = response.litecoin.usd_24h_change.toFixed(2)+'%';
   
   eth_change1.innerHTML = response.ethereum.usd_24h_change.toFixed(2)+'%';
   eth_change2.innerHTML = response.ethereum.usd_24h_change.toFixed(2)+'%';
   eth_change3.innerHTML = response.ethereum.usd_24h_change.toFixed(2)+'%';
   
   tet_change1.innerHTML = response.tether.usd_24h_change.toFixed(2)+'%';
   tet_change2.innerHTML = response.tether.usd_24h_change.toFixed(2)+'%';
   tet_change3.innerHTML = response.tether.usd_24h_change.toFixed(2)+'%';
   
   

});
