// Initialize Firebase
var config = {
  apiKey: "AIzaSyB375ZkbrouviVJ1YG7_3n8K3jAhIXlsOU",
  authDomain: "amu-roboclub.firebaseapp.com",
  databaseURL: "https://amu-roboclub.firebaseio.com",
  storageBucket: "amu-roboclub.appspot.com",
  messagingSenderId: "911524271284"
};

firebase.initializeApp(config);

function saveUsertoDatabase(user) {
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

  progress(true);
  currentUser.updateProfile({
    displayName: username,
    photoURL: photo
  }).then(function() {
    progress(false);
    alert('Settings Saved!');
    location = location;
  }, function(error) {
    progress(false);
    alert(error);
  });
}

function progress(show) {
  const progressBar = document.getElementById('progress-bar');
  toggleVisibility(show, progressBar);
}

function changeProfilePic(url) {
  progress(true);
  if(url == null || url == 'null' || url == '') {
    avatar.src = 'https://res.cloudinary.com/amuroboclub/image/upload/person.svg';
  } else {
    avatar.src = url;
  }
}

function loadProfileSettings(username, currentPhoto, userProvider) {
  changeProfilePic(currentPhoto);

  $(avatar).load(function() {
    progress(false);
  });

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
    changeProfilePic(this.value);
  }

  name.value = username;

  document.getElementById('profile-form').onsubmit = function() {
    updateProfile(name.value, photoSelect.options.item(photoSelect.options.selectedIndex).value);
    return false;
  };
}

function pushNewsToDatabase(newsObject) {
  progress(true);
  firebase.database().ref('news/').push(newsObject)
    .then(function() {
      progress(false);
      alert('News posted successfully');
    })
    .catch(function(error) {
      progress(false);
      alert('An error occurred! \n' + error + '\n You do not have permission to send notiifcatons');
    });
}

function requestFCM(message_title, message_body) {
  const requestObject = {
    title : message_title,
    message : message_body
  };

  progress(true);

  handleResponse = function(responseData) {
    console.log(responseData);
  };

  firebase.auth().currentUser.getToken().then(function(idToken) {
    $.ajax(
      {
        type: "POST",
        url: "./send_notification",
        headers: {
            'Authorization': "Bearer " + idToken
        },
        crossDomain: false,
        data: requestObject,
        dataType: 'json',
        success: function(responseData, status, xhr) {
          progress(false);
          handleResponse(responseData);
        },
        error: function(request, status, error) {
          progress(false);
          alert(error);
        }
      }
    );
  }).catch(function(error) {
    alert(error);
  });

}

function sendNotification(title, message, link) {
  if(title == null || message == null) {
    alert("Can't send empty message");
    return;
  } else if(title.length < 5 || message.length < 5) {
    alert("Title or Message is too small");
    return;
  }

  const date = new Date();

  var newsObject = {
    notice : message,
    date : date.toDateString()
  };

  console.log(link);
  if(link != null && link.length > 5)
    newsObject.link = link;

  pushNewsToDatabase(newsObject);
  requestFCM(title, message);

}

function initializeNotificationPanel() {
  const title = document.getElementById('title');
  const message = document.getElementById('message');
  const link = document.getElementById('link');

  document.getElementById('notification-form').onsubmit = function() {
    //sendNotification(title.value, message.value, link.value);
    requestFCM('Test', 'New Message');

    return false;
  };
}

function populateOptions(user) {
  loadProfileSettings(user.displayName, user.photoURL, user.providerData);
  initializeNotificationPanel();
  /*$('#tab-notification').click(function() {
    alert("Ability for notifications coming soon!");
  });*/
}


function initApp() {
  const signinButton = document.getElementById('sign-in');
  const welcome = document.getElementById('welcome');
  const profile_info = document.getElementById('account-detail');

  progress(true);

  firebase.auth().onAuthStateChanged(function(user) {
    progress(false);

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

      saveUsertoDatabase(userData);
      
      welcome.innerHTML = 'Welcome, <strong>' + userData.name + '</strong>';
      signinButton.textContent = 'Sign out';
      signinButton.onclick = function() {
        firebase.auth().signOut();
      };

      toggleVisibility(true, profile_info);
      populateOptions(user);
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