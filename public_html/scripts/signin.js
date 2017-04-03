var SigninPanel = function () {
    FirebaseOps.startSigninUI();

    const container = document.getElementById('firebaseui-auth-container');
    const signinStatus = document.getElementById('sign-in-status');
    const adminButton = document.getElementById('admin-button');
    const signoutButton = document.getElementById('sign-out');

	return {
    	initialize: function () {
            FirebaseOps.onAuthChanged(function (user) {
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
        }
	}

}();

window.addEventListener('load', function() {
	SigninPanel.initialize();
});