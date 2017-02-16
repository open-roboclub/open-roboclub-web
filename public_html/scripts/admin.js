
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

const newsRef = 'news/';

function loadEditNotification(key) {
  const editNotification = document.getElementById('edit-form');
  const newsKey = $("#newsKey");
  const newsMessage = $("#edit-message");

  newsKey.val(key);

  const updateNotification = function() {
    toggleVisibility(true, editNotification);
    editNotification.onsubmit = function() {
      pushNewsToDatabase(newsMessage.val(), key);
      return false;
    };
  };

  firebase.database().ref(newsRef + key).once('value').then(function(snapshot) {
    newsMessage.val(snapshot.val().notice);
    updateNotification();
  })
  .catch(function(error) {
    console.log(error);
  });

}

function pushNewsToDatabase(newsObject, key) {
  progress(true);

  if(key) {
    firebase.database().ref(newsRef+key).update({
      notice : newsObject
    }).then(function() {
      progress(false);
      show(toastr.success('Message successfully updated!'));
    });

    return;
  }

  firebase.database().ref(newsRef).push(newsObject)
    .then(function(snapshot) {
      progress(false);
      show(toastr.success('News posted successfully'));

      try { loadEditNotification(snapshot.key); } catch(error) { console.log(error); };
    })
    .catch(function(error) {
      progress(false);
      showError('An error occurred! \n' + error + '\n You do not have permission to send notiifcatons');
    });
}

function requestFCM(message_title, message_body) {
  const requestObject = {
    title : message_title,
    message : message_body
  }

  progress(true);

  const successFunction = function(responseData, status, xhr) {
    progress(false);

    if (responseData.error) {
      showError(responseData.message);
    } else {
      show(toastr.success('Notification ' + responseData.message + ' Message ID : ' + responseData.message_id));
    }
  };

  const errorFunction = function(request, status, error) {
    progress(false);
    showError('Error ' + error);
  };

  firebase.auth().currentUser.getToken().then(function(idToken) {

    request(
      'POST',
      './send_notification', 
      {
        'Authorization': "Bearer " + idToken
      },
      requestObject,
      successFunction,
      errorFunction
    );

  }).catch(function(error) {
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

  var option = $("input[name='sendOptions']:checked").val();

  switch(option) {
    case 'news':
      pushNewsToDatabase(newsObject);
      break;
    case 'notification':
      requestFCM(title, message);
      break;
    default:
      pushNewsToDatabase(newsObject);
      requestFCM(title, message);
  }

}

function initializeNotificationPanel(uid) {
  const notificationPanel = document.getElementById('notification');
  const notificationTab = document.getElementById('tab-notification');
  const editNotification = document.getElementById('edit-form');

  toggleVisibilities(false, [notificationPanel, notificationTab, editNotification]);

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

  document.getElementById('edit-form').onsubmit = function() {
    showError('No message to edit');
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