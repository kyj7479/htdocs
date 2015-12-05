"use strict";

document.observe("dom:loaded", function() {
	/* Make necessary elements Dragabble / Droppables (Hint: use $$ function to get all images).
	 * All Droppables should call 'labSelect' function on 'onDrop' event. (Hint: set revert option appropriately!)
	 * 필요한 모든 element들을 Dragabble 혹은 Droppables로 만드시오 (힌트 $$ 함수를 사용하여 모든 image들을 찾으시오).
	 * 모든 Droppables는 'onDrop' 이벤트 발생시 'labSelect' function을 부르도록 작성 하시오. (힌트: revert옵션을 적절히 지정하시오!)
	 */
	var images = $$("#labs img");
	for(var i=0; i < images.length; i++) {
		new Draggable(images[i], {revert:true});
		Droppables.add("selectpad", {onDrop: labSelect});	
	}
	
	var selectedImages = $$("#selectpad img");
	for(var i=0; i < images.length; i++) {
		new Draggable(images[i], {revert:true});
		Droppables.add("labs", {onDrop: labSelect});	
	}

});

function labSelect(drag, drop, event) {
	/* Complete this event-handler function 
	 * 이 event-handler function을 작성하시오.
	 */
	if($$("#selectpad img").length < 3 && drag.parentNode==$("labs") && drop==$("selectpad")) {
		$("selectpad").appendChild(drag);
		var newLi = document.createElement("li");
		newLi.appendChild(document.createTextNode(drag.alt));
		$("selection").appendChild(newLi);
		newLi.pulsate ({
			delay:0.5,
			duration:1.0
		});
		return;
	}
	if(drag.parentNode==$("selectpad") && drop==$("labs")) {
		$("labs").appendChild(drag);
		var selectedList = $$("#selection li");
		for(var i=0; i<selectedList.length; i++) {
			if(selectedList[i].innerHTML==drag.alt) {
				selectedList[i].remove();
			}
		}
	}
}

