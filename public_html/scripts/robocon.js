$(function() {

    var roboconContainer;

    function toggleLoader(show) {
        toggleVisibility(!show, roboconContainer);
        loaders(show);
    }

    const received = function(data, status, xhr) {
        toggleLoader(false);
        $('#robocon-container').html(data);
    }

    const error = function(request, status, error) {
        toggleLoader(false);
        console.log(error);
    }

    function loadPage(robocon, downloads) {
        const obj = {
            robocon : robocon,
            downloads : downloads
        }

        toggleLoader(true);

        $.ajax(
            {
                type: 'POST',
                url: base_url + '/robocon',
                data: obj,
                success: received,
                error: error
            }
        );
    }

    window.addEventListener('load', function() {

        roboconContainer = document.getElementById('robocon-container');

        toggleLoader(true);

        var synced = 0;

        var robocon, downloads;

        firebase.database().ref('robocon/17').on('value', function(snap) {

            robocon = snap.val();

            if(synced < 1) {
                toggleLoader(false);
                synced++;
            } else {
                loadPage(robocon, downloads);
            }

        }, function(error) {
            toggleLoader(false);
            console.log(error);
        });

        firebase.database().ref('downloads/robocon').on('value', function(snap) {

            downloads = snap.val();

            if(synced < 1) {
                toggleLoader(false);
                synced++;
            } else {
                loadPage(robocon, downloads);
            }

        }, function(error) {
            toggleLoader(false);
            console.log(error);
        });

    });
});