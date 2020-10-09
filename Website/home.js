function signOut(){

	sessionStorage.clear();

	var urlParts = window.location.href.split('/');
	var url = "";
	for(var i = 0; i < urlParts.length -1; i++){
		url += urlParts[i] + "/";
	}
	url += "index.html";
	window.location = url;

}

/*function loadProfile(){
	var profile = JSON.parse(sessionStorage.getItem("profile"));

	$(".profileData").css("display","block");
	$("#email").text(profile.yu);
}*/