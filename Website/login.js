function onSignIn(userInfo){
	sessionStorage.setItem('profile', JSON.stringify(userInfo.getBasicProfile()));

	var urlParts = window.location.href.split('/');
	var url = "";
	for(var i = 0; i < urlParts.length -1; i++){
		url += urlParts[i] + "/";
	}
	url += "home.php";
	window.location = url;
}