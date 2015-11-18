var interval = 3000;
var numberOfBlocks = 9;
var numberOfTarget = 3;
var targetBlocks = [];
var selectedBlocks = [];
var timer;

document.observe('dom:loaded', function(){
	$("start").observe("click", stopToStart);
	$("stop").observe("click", stopGame);
});

function stopToStart() {
    stopGame();
    startToSetTarget();
}

function stopGame(){
	$("state").innerHTML = "Stop";
	$("answer").innerHTML = "0/0";
	targetBlocks = [];
	selectedBlocks = [];
	clearTimeout(timer);
	for(var i=0; i < numberOfBlocks; i++) {
		$$("div.block")[i].stopObserving("click");
		$$('div.block')[i].removeClassName("selected");
		$$('div.block')[i].removeClassName("target");
	}
}

function startToSetTarget(){
	targetBlocks = [];
	selectedBlocks = [];
	$("state").innerHTML = "Ready!";
	for(var i=0; i < numberOfBlocks; i++) {
		var num = Math.random();
		if(num > 0.5) {
			targetBlocks.push(i);
		}
	}
	timer = setTimeout(setTargetToShow, interval);
}

function setTargetToShow(){
	$("state").innerHTML = "Memorize!";
	for(var i=0; i < targetBlocks.length; i++) {
		$$('div.block')[targetBlocks[i]].addClassName("target");
	}
	timer = setTimeout(showToSelect, interval);
}

function showToSelect(){
	$("state").innerHTML = "Select!";
	for(var i=0; i < targetBlocks.length; i++) {
		$$('div.block')[targetBlocks[i]].removeClassName("target");
	}
	for(var i=0; i < numberOfBlocks; i++) {
		$$("div.block")[i].observe("click", function() {
			if(notOverlap(this)) {
				this.addClassName("selected");
				selectedBlocks.push(this.getAttribute("data-index"));	
			}
		});
	}
	timer = setTimeout(selectToResult, interval);
}

function selectToResult(){
	$("state").innerHTML = "Checking";
	for(var i=0; i < selectedBlocks.length; i++) {
		$$('div.block')[selectedBlocks[i]].removeClassName("selected");
	}
	for(var i=0; i < numberOfBlocks; i++) {
		$$("div.block")[i].stopObserving("click");
	}
	var correct = parseInt($('answer').innerHTML.split('/')[0]);
	var total = parseInt($('answer').innerHTML.split('/')[1]);
	for(var i = 0; i < targetBlocks.length; i++) {
		total++;
		for(var j = 0; j < selectedBlocks.length; j++) {
			if(targetBlocks[i] == selectedBlocks[j]) {
				correct++;
			}
		}
		$('answer').innerHTML = correct+"/"+total;
	}
	timer = setTimeout(startToSetTarget, interval);
}

function notOverlap(check) {
	for(var i = 0; i < selectedBlocks.length; i++) {
		if(selectedBlocks[i]==check.getAttribute("data-index")) {
			return false;
		}
	}
	return true;
}
