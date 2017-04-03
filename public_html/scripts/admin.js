var DatabaseOps = function () {

    const newsRef = 'news/';

    function getNewsRef() {
        return newsRef;
    }

    function saveUser(user) {
        FirebaseOps.getDatabaseReference('users/' + user.uid).set(user)
            .then(function () {
                console.log('Synchronization succeeded');
            })
            .catch(function (error) {
                console.log('Synchronization failed!\n' + error);
            });
    }

    function updateProfile(username, photo) {
        const currentUser = firebase.auth().currentUser;

        if (!currentUser) {
            App.showErrorToast("You're logged out!");
            return;
        }

        App.showProgressBar(true);
        currentUser.updateProfile({
            displayName: username,
            photoURL: photo
        }).then(function () {
            App.showProgressBar(false);
            App.showToast(toastr.success('Profile updated successfully!'));
        }, function (error) {
            App.showProgressBar(false);
            App.showErrorToast(error);
        });
    }

    function pushNews(newsObject, key) {
        App.showProgressBar(true);

        if (key) {
            FirebaseOps.getDatabaseReference(newsRef + key).update({
                notice: newsObject.replace(/\n/g, "\\n")
            }).then(function () {
                App.showProgressBar(false);
                App.showToast(toastr.success('Message successfully updated!'));
            });

            return;
        }

        newsObject.notice = newsObject.notice.replace(/\n/g, "\\n");

        FirebaseOps.getDatabaseReference(newsRef).push(newsObject)
            .then(function (snapshot) {
                App.showProgressBar(false);
                App.showToast(toastr.success('News posted successfully'));

                try {
                    AdminPanel.loadEditNews(snapshot.key);
                } catch (error) {
                    console.log(error);
                }
            })
            .catch(function (error) {
                App.showProgressBar(false);
                App.showErrorToast('An error occurred! \n' + error + '\n You do not have permission to send notifications');
            });
    }

    function deleteNews(key) {
        FirebaseOps.getDatabaseReference(newsRef + key).remove().then(function () {
            App.showProgressBar(false);
            App.showToast(toastr.success('Announcement Deleted'));
            App.toggleVisibility(false, AdminPanel.elements.editForm);
        }).catch(function (error) {
            App.showErrorToast(false);
            App.showErrorToast(error);
        });
    }

    function requestFCM(message_title, message_body) {
        const requestObject = {
            title: message_title,
            message: message_body
        };

        App.showProgressBar(true);

        const successFunction = function (responseData) {
            App.showProgressBar(false);

            if (responseData.error) {
                App.showErrorToast(responseData.message);
            } else {
                App.showToast(toastr.success('Notification ' + responseData.message + ' Message ID : ' + responseData.message_id));
            }
        };

        const errorFunction = function (request, status, error) {
            App.showProgressBar(false);
            App.showErrorToast('Error ' + error);
        };

        firebase.auth().currentUser.getToken().then(function (idToken) {
            FirebaseOps.request(
                'POST',
                './send_notification',
                {
                    'Authorization': "Bearer " + idToken
                },
                requestObject,
                successFunction,
                errorFunction
            );

        }).catch(function (error) {
            App.showProgressBar(false);
            App.showErrorToast(error);
        });
    }

    function sendNotification(title, message, link) {
        if (title == null || message == null) {
            App.showErrorToast("Can't send empty message");
            return;
        } else if (title.length < 4 || message.length < 5) {
            App.showErrorToast("Title or Message is too small");
            return;
        }

        const date = $.format.date(new Date().getTime(), 'ddd, D MMMM yyyy');

        var newsObject = {
            notice: message,
            date: date,
            timestamp: -Math.floor(Date.now() / 1000)
        };

        if (link != null && link.length > 5)
            newsObject.link = link;

        var option = $("input[name='sendOptions']:checked").val();

        switch (option) {
            case 'news':
                pushNews(newsObject);
                break;
            case 'notification':
                requestFCM(title, message);
                break;
            default:
                pushNews(newsObject);
                requestFCM(title, message);
        }

    }

    return {
        getNewsRef: getNewsRef,
        saveUser: saveUser,
        pushNews: pushNews,
        deleteNews: deleteNews,
        sendNotification: sendNotification
    }
}();


var AdminPanel = function () {

    function changeProfilePic(url) {
        App.showProgressBar(true);
        if (url == null || url == 'null' || url == '') {
            AdminPanel.elements.avatar.src = 'https://res.cloudinary.com/amuroboclub/image/upload/person.svg';
        } else {
            AdminPanel.elements.avatar.src = url;
        }
    }

    function loadProfileSettings(username, currentPhoto, userProvider) {
        changeProfilePic(currentPhoto);

        $(AdminPanel.elements.avatar).load(function () {
            App.showProgressBar(false);
        });

        const name = document.getElementById('inputName');
        const photoSelect = document.getElementById('select');

        var option = document.createElement('option');
        option.value = currentPhoto;
        option.text = 'Default Photo (Current)';
        photoSelect.options.add(option);

        userProvider.forEach(function (profile) {
            option = document.createElement('option');
            option.value = profile.photoURL;
            option.text = profile.providerId;
            photoSelect.options.add(option);
        });

        photoSelect.onchange = function () {
            changeProfilePic(this.value);
        };

        name.value = username;

        document.getElementById('profile-form').onsubmit = function () {
            updateProfile(name.value, photoSelect.options.item(photoSelect.options.selectedIndex).value);
            return false;
        };
    }

    function loadEditNews(key) {
        const editForm = document.getElementById('edit-form');
        AdminPanel.elements.editForm = document.getElementById('edit-form');

        const editNews = document.getElementById('update-news');
        const deleteNews = document.getElementById('delete-news');
        const newsKey = $("#newsKey");
        const newsMessage = $("#edit-message");

        newsKey.val(key);

        editNews.onclick = function () {
            DatabaseOps.pushNews(newsMessage.val(), key);
        };

        deleteNews.onclick = function () {
            App.showProgressBar(true);
            DatabaseOps.deleteNews(key)
        };

        FirebaseOps.getDatabaseReference(DatabaseOps.getNewsRef() + key)
            .once('value')
            .then(function (snapshot) {
                newsMessage.val(snapshot.val().notice);
                App.toggleVisibility(true, editForm);
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function initializeNotificationPanel(uid) {
        const notificationPanel = document.getElementById('notification');
        const notificationTab = document.getElementById('tab-notification');
        const editNews = document.getElementById('edit-form');

        App.toggleVisibilities(false, [notificationPanel, notificationTab, editNews]);

        App.showProgressBar(true);
        const key = '/admins/' + uid;
        FirebaseOps.getDatabaseReference(key).once('value').then(function (snapshot) {
            if (snapshot.val()) {
                App.toggleVisibilities(true, [notificationPanel, notificationTab]);
            }
            App.showProgressBar(false);
        });

        const title = document.getElementById('title');
        const message = document.getElementById('message');
        const link = document.getElementById('link');

        document.getElementById('notification-form').onsubmit = function () {
            DatabaseOps.sendNotification(title.value, message.value, link.value);

            console.log('clicked');
            return false;
        };

        document.getElementById('update-news').onclick = function () {
            App.showErrorToast('No message to edit');
        };
    }

    function populateOptions(user) {
        loadProfileSettings(user.displayName, user.photoURL, user.providerData);
        initializeNotificationPanel(user.uid);
    }

    function setupUSerInfo(user) {
        // User is signed in.
        const userData = {
            'name': user.displayName,
            'email': user.email,
            'emailVerified': user.emailVerified,
            'photoURL': user.photoURL,
            'uid': user.uid,
            'providerData': user.providerData
        };

        console.log(userData);

        DatabaseOps.saveUser(userData);

        AdminPanel.elements.welcome.innerHTML = 'Welcome, <strong>' + userData.name + '</strong>';
        AdminPanel.elements.signinButton.textContent = 'Sign out';
        AdminPanel.elements.signinButton.onclick = FirebaseOps.signOut;

        App.toggleVisibility(true, AdminPanel.elements.profile_info);
        populateOptions(user);
    }

    function hideUserInfo() {
        // User is signed out.
        AdminPanel.elements.signinButton.textContent = 'Sign in';
        AdminPanel.elements.welcome.textContent = 'You\'re signed out!';
        AdminPanel.elements.signinButton.onclick = function () {
            location.href = './signin';
        };

        App.toggleVisibility(false, AdminPanel.elements.profile_info);
    }

    function initApp() {

        App.showProgressAndAnimation(true);

        FirebaseOps.onAuthChanged(function (user) {
            App.showProgressAndAnimation(false);

            if (user) {
                setupUSerInfo(user);
            } else {
                hideUserInfo();
            }
        }, App.showErrorToast);
    }

    return {
        elements: {
            signinButton: document.getElementById('sign-in'),
            welcome: document.getElementById('welcome'),
            profile_info: document.getElementById('account-detail'),
            avatar: document.getElementById('avatar')
        },
        loadEditNews: loadEditNews,
        initialize: initApp
    }
}();



window.addEventListener('load', function () {
    AdminPanel.initialize();
});