// Initialize Firebase
var config = {
  apiKey: "AIzaSyB375ZkbrouviVJ1YG7_3n8K3jAhIXlsOU",
  authDomain: "amu-roboclub.firebaseapp.com",
  databaseURL: "https://amu-roboclub.firebaseio.com",
  storageBucket: "amu-roboclub.appspot.com",
  messagingSenderId: "911524271284"
};

firebase.initializeApp(config);

function savetoDatabase(user) {
  firebase.database().ref('users/' + user.uid).set(user)
    .then(function() {
      console.log('Synchronization succeeded');
    })
    .catch(function(error) {
      console.log('Synchronization failed');
    });
}

function toggleVisibility(show, view) {
  if (show) {
    view.style.display = 'block';
  } else {
    view.style.display = 'none';
  }
}

function updateProfile(username, photo) {
  const currentUser = firebase.auth().currentUser;

  if (!currentUser) {
    alert("You're logged out!");
    return;
  }

  currentUser.updateProfile({
    displayName: username,
    photoURL: photo
  }).then(function() {
    alert('Settings Saved!');
    location = location;
  }, function(error) {
    alert(error);
  });
}

function loadProfileSettings(username, currentPhoto, userProvider) {
  const name = document.getElementById('inputName');
  const photoSelect = document.getElementById('select');

  option = document.createElement('option');
  option.value = currentPhoto;
  option.text = 'Default Photo (Current)';
  photoSelect.options.add(option);

  userProvider.forEach(function(profile) {
    option = document.createElement('option');
    option.value = profile.photoURL;
    option.text = profile.providerId;
    photoSelect.options.add(option);
  });

  photoSelect.onchange = function() {
    avatar.src = this.value;
  }

  name.value = username;

  document.getElementById('profile-form').onsubmit = function() {
    updateProfile(name.value, photoSelect.options.item(photoSelect.options.selectedIndex).value);
    return false;
  };
}

function initApp() {
  const signinButton = document.getElementById('sign-in');
  const welcome = document.getElementById('welcome');
  const profile_info = document.getElementById('profile-info');

  firebase.auth().onAuthStateChanged(function(user) {

    if (user) {
      // User is signed in.

      const avatar = document.getElementById('avatar');
      const userData = {
        'name': user.displayName,
        'email': user.email,
        'emailVerified': user.emailVerified,
        'photoURL': user.photoURL,
        'uid': user.uid,
        'providerData': user.providerData
      };

      savetoDatabase(userData);

      avatar.src = userData.photoURL;
      welcome.textContent = 'Welcome, ' + userData.name;
      signinButton.textContent = 'Sign out';
      signinButton.onclick = function() {
        firebase.auth().signOut();
      };

      var show = true;
      document.getElementById('change-profile').onclick = function() {
        toggleVisibility(show, document.getElementById('profile-form'));
        show = !show;
      };

      toggleVisibility(true, profile_info);
      loadProfileSettings(user.displayName, user.photoURL, user.providerData);
    } else {
      // User is signed out.
      signinButton.textContent = 'Sign in';
      welcome.textContent = 'You\'re signed out!';
      signinButton.onclick = function() {
        location.href = './signin';
      };

      toggleVisibility(false, profile_info);
    }
  }, function(error) {
    console.log(error);
  });
};

window.addEventListener('load', function() {
  initApp()
});