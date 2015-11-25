document.observe("dom:loaded", function() {
    $("b_xml").observe("click", function(){
    	new Ajax.Request("./songs_xml.php", {
    		method: "get",
    		parameters: {top: $F("top")},
    		onSuccess: showSongs_XML,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});	
    });
    $("b_json").observe("click", function(){
    	new Ajax.Request("./songs_json.php", {
    		method: "get",
    		parameters: {top: $F("top")},
    		onSuccess: showSongs_JSON,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});
    });
});

function showSongs_XML(ajax) {
	document.getElementById("songs").innerHTML = "";
	var songs = ajax.responseXML.getElementsByTagName("song");
	for(var i=0; i<songs.length; i++) {
		for(var j=0; j<songs.length; j++) {
			if(songs[j].getAttribute("rank")-1 == i) {
				var title=songs[j].getElementsByTagName("title")[0].firstChild.nodeValue;
				var artist=songs[j].getElementsByTagName("artist")[0].firstChild.nodeValue;
				var genre=songs[j].getElementsByTagName("genre")[0].firstChild.nodeValue;
				var time=songs[j].getElementsByTagName("time")[0].firstChild.nodeValue;
				var txt = title+" - "+artist+"["+genre+"]("+time+")";
				var newLI = document.createElement("li");
				var newText = document.createTextNode(txt);
				newLI.appendChild(newText);
				$("songs").appendChild(newLI);
			}
		}
	}
}

function showSongs_JSON(ajax) {
	document.getElementById("songs").innerHTML = "";
	var data = JSON.parse(ajax.responseText);
	for(var i=0; i<data.songs.length; i++) {
		for(var j=0; j<data.songs.length; j++) {
			if(data.songs[j].rank-1 == i) {
				var txt = data.songs[j].title+" - "+data.songs[j].artist+"["+data.songs[j].genre+"]("+data.songs[j].time+")";
				var newLI = document.createElement("li");
				var newText = document.createTextNode(txt);
				newLI.appendChild(newText);
				$("songs").appendChild(newLI);
			}
		}
	}
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}
