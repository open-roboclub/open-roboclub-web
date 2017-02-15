const base_url = $('#base_url').text();

// Initialize Firebase

var config = {
	apiKey: "AIzaSyB375ZkbrouviVJ1YG7_3n8K3jAhIXlsOU",
	authDomain: "amu-roboclub.firebaseapp.com",
	databaseURL: "https://amu-roboclub.firebaseio.com",
	storageBucket: "amu-roboclub.appspot.com",
	messagingSenderId: "911524271284"
};

firebase.initializeApp(config);

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "timeOut": "2000"
}

function toggleVisibility(show, view) {
  if (show) {
    view.style.display = 'block';
  } else {
    view.style.display = 'none';
  }
}

function toggleVisibilities(show, views) {
  for(var i = 0; i < views.length; i++) {
    toggleVisibility(show, views[i]);
  }
}

var progressCount = 0;
function progress(show) {
  const progressBar = document.getElementById('progress-bar');

  if(show) 
    progressCount++;
  else
    progressCount--;

  if(progressCount > 0)
    toggleVisibility(true, progressBar);
  else
    toggleVisibility(false, progressBar);
}

function show(notification) {
  notification.css("top", 70);
}

function showError(error) {
  show(toastr.error(error));
}

function signOut() {
  firebase.auth().signOut();
}

window.addEventListener('load', function() {
  const signinButton = $('#signin-button');
  const signinLink = $('#signin-link');

  firebase.auth().onAuthStateChanged(function(user) {
  	if(user) {
  	  signinButton.text('Admin Panel');
  	  signinButton.removeClass('btn-primary');
  	  signinButton.addClass('btn-info');

  	  signinLink.prop('href', base_url + '/admin');
  	} else {
  	  signinButton.text('Sign In');
  	  signinButton.removeClass('btn-info');
  	  signinButton.addClass('btn-primary');

  	  signinLink.prop('href', base_url + '/signin');
  	}
  }, function(error) {
    console.log(error);
  });
});