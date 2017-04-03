var FirebaseOps = function () {

    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyB375ZkbrouviVJ1YG7_3n8K3jAhIXlsOU",
        authDomain: "amu-roboclub.firebaseapp.com",
        databaseURL: "https://amu-roboclub.firebaseio.com",
        storageBucket: "amu-roboclub.appspot.com",
        messagingSenderId: "911524271284"
    };

    firebase.initializeApp(config);

    function signOut() {
        firebase.auth().signOut();
    }

    function getDatabaseReference(path) {
        //noinspection JSUnresolvedFunction
        return firebase.database().ref(path)
    }

    function request(request_type, request_url, header, requestObject, successFunction, errorFunction) {
        $.ajax(
            {
                async: true,
                type: request_type,
                url: request_url,
                headers: header,
                crossDomain: false,
                data: requestObject,
                dataType: 'json',
                success: successFunction,
                error: errorFunction
            }
        );
    }

    var uiConfig = {
        signInSuccessUrl: 'admin',
        signInOptions: [
            firebase.auth.EmailAuthProvider.PROVIDER_ID,
            firebase.auth.GoogleAuthProvider.PROVIDER_ID,
            firebase.auth.FacebookAuthProvider.PROVIDER_ID,
            firebase.auth.GithubAuthProvider.PROVIDER_ID
        ]
    };

    function startSigninUI() {
        // Initialize the FirebaseUI Widget using Firebase.
        var ui = new firebaseui.auth.AuthUI(firebase.auth());
        // The start method will wait until the DOM is loaded.
        ui.start('#firebaseui-auth-container', uiConfig);
    }

    function onAuthChanged(callback) {
        firebase.auth().onAuthStateChanged(function (user) {
            callback(user);
        });
    }

    function updateSigninInfo() {
        FirebaseOps.onAuthChanged(function(user) {
            if(user) {
                App.elements.signinButton.text('Admin Panel');
                App.elements.signinButton.removeClass('btn-primary');
                App.elements.signinButton.addClass('btn-info');

                App.elements.signinLink.prop('href', base_url + '/admin');
            } else {
                App.elements.signinButton.text('Sign In');
                App.elements.signinButton.removeClass('btn-info');
                App.elements.signinButton.addClass('btn-primary');

                App.elements.signinLink.prop('href', base_url + '/signin');
            }
        }, function(error) {
            console.log(error);
        });
    }

    return {
        signOut: signOut,
        startSigninUI: startSigninUI,
        onAuthChanged: onAuthChanged,
        updateSigninInfo: updateSigninInfo,
        getDatabaseReference: getDatabaseReference,
        request: request
    };
}();


window.addEventListener('load', function() {
    FirebaseOps.updateSigninInfo();
});