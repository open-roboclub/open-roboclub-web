
function saveUsertoDatabase(user) {
  firebase.database().ref('users/' + user.uid).set(user)
    .then(function() {
      console.log('Synchronization succeeded');
    })
    .catch(function(error) {
      console.log('Synchronization failed');
    });
}

function updateProfile(username, photo) {
  const currentUser = firebase.auth().currentUser;

  if (!currentUser) {
    showError("You're logged out!");
    return;
  }

  progress(true);
  currentUser.updateProfile({
    displayName: username,
    photoURL: photo
  }).then(function() {
    progress(false);
    show(toastr.success('Profile updated successfully!'));
  }, function(error) {
    progress(false);
    showError(error);
  });
}

function changeProfilePic(url) {
  progress(true);
  if(url == null || url == 'null' || url == '') {
    avatar.src = 'https://res.cloudinary.com/amuroboclub/image/upload/person.svg';
  } else {
    avatar.src = url;
  }
}

completed = false;

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
      if(completed) progress(false);
      show(toastr.success('News posted successfully'));
    })
    .catch(function(error) {
      if(completed) progress(false);
      showError('An error occurred! \n' + error + '\n You do not have permission to send notiifcatons');
    });
}

function requestFCM(message_title, message_body) {
  const requestObject = {
    title : message_title,
    message : message_body
  }

  progress(true);

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
          completed = true;
          progress(false);

          if (responseData.error) {
            showError(responseData.message);
          } else {
            show(toastr.success(responseData.message + '\nMessage ID : ' + responseData.message_id));
          }
        },
        error: function(request, status, error) {
          completed = true;
          progress(false);
          showError('Error ' + error);
        }
      }
    );

  }).catch(function(error) {
    completed = true;
    progress(false);
    showError(error);
  });

}

function sendNotification(title, message, link) {
  if(title == null || message == null) {
    showError("Can't send empty message");
    return;
  } else if(title.length < 4 || message.length < 5) {
    showError("Title or Message is too small");
    return;
  }

  const date = new Date();

  var newsObject = {
    notice : message,
    date : date.toDateString()
  };

  if(link != null && link.length > 5)
    newsObject.link = link;

  completed = false;
  pushNewsToDatabase(newsObject);
  requestFCM(title, message);

}

function initializeNotificationPanel(uid) {
  const notificationPanel = document.getElementById('notification');
  const notificationTab = document.getElementById('tab-notification');

  toggleVisibilities(false, [notificationPanel, notificationTab]);

  progress(true);
  const key = '/admins/'+uid;
  firebase.database().ref(key).once('value').then(function(snapshot) {
    if(snapshot.val()) {
      toggleVisibilities(true, [notificationPanel, notificationTab]);
    }
    progress(false);
  });


  const title = document.getElementById('title');
  const message = document.getElementById('message');
  const link = document.getElementById('link');

  document.getElementById('notification-form').onsubmit = function() {
    sendNotification(title.value, message.value, link.value);

    return false;
  };
}

function populateOptions(user) {
  loadProfileSettings(user.displayName, user.photoURL, user.providerData);
  initializeNotificationPanel(user.uid);
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
      signinButton.onclick = signOut;

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
  }, showError);
};

window.addEventListener('load', function() {
  initApp();
});