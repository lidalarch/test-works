function send(itid) { //обработка добавления комментария
	var commPlace = "#commPlace"+itid;
	var email = "#email"+itid;
	var comm = "#comm"+itid;
	
	var vEmail = $(email).val();
	var vComm = $(comm).val();
	var vTime = String(new Date());
	
	$.ajax({
		type: "POST",
		url: "update.php",
		cache: false,
		data: {
		"itemID": itid,
		"pubTime": vTime,
		"email": vEmail,
		"comm": vComm
		},
		success: function(html){
			$(email).val("");
			$(comm).val("");
			$(commPlace).append(html);
		}
	})
}