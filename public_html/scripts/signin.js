
// FirebaseUI config.
var uiConfig = {
  signInSuccessUrl: 'admin',
  signInOptions: [
    firebase.auth.EmailAuthProvider.PROVIDER_ID,
    firebase.auth.GoogleAuthProvider.PROVIDER_ID,
    firebase.auth.FacebookAuthProvider.PROVIDER_ID,
    firebase.auth.GithubAuthProvider.PROVIDER_ID
  ]
};

// Initialize the FirebaseUI Widget using Firebase.
var ui = new firebaseui.auth.AuthUI(firebase.auth());
// The start method will wait until the DOM is loaded.
ui.start('#firebaseui-auth-container', uiConfig);

initApp = function () {
  firebase.auth().onAuthStateChanged(function(user) {
  	const container = document.getElementById('firebaseui-auth-container');
  	const signinStatus = document.getElementById('sign-in-status');
  	const adminButton = document.getElementById('admin-button');
  	const signoutButton = document.getElementById('sign-out');

  	if (user) {
  		container.style.display = 'none';
  		adminButton.style.display = 'block';
  		signinStatus.textContent = 'You\'re already signed in!';
  		signoutButton.onclick = function() {
  			firebase.auth().signOut();
  		};
  	} else {
  		container.style.display = 'block';
  		adminButton.style.display = 'none';
  		signinStatus.textContent = 'Sign In';
  		signoutButton.onclick = null;
  	}
  });
};

window.addEventListener('load', function() {
  initApp();
});