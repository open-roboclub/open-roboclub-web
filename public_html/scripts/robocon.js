var RoboconPanel = function () {

    const received = function(data) {
        App.showProgressBar(false);
        $('#robocon-container').html(data);
    };

    const error = function(request, status, error) {
        App.showProgressBar(false);
        console.log(error);
    };

    function loadPage(robocon, downloads) {
        const obj = {
            robocon : robocon,
            downloads : downloads
        };

        App.showProgressBar(true);

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

    return {
        initialize: function () {
            App.showProgressBar(true);

            var synced = 0;

            var robocon, downloads;

            FirebaseOps.getDatabaseReference('robocon/17').on('value', function(snap) {

                robocon = snap.val();

                if(synced < 1) {
                    App.showProgressBar(false);
                    synced++;
                } else {
                    loadPage(robocon, downloads);
                }

            }, function(error) {
                App.showProgressBar(false);
                console.log(error);
            });

            FirebaseOps.getDatabaseReference('downloads/robocon').on('value', function(snap) {

                downloads = snap.val();

                if(synced < 1) {
                    App.showProgressBar(false);
                    synced++;
                } else {
                    loadPage(robocon, downloads);
                }

            }, function(error) {
                App.showProgressBar(false);
                console.log(error);
            });
        }
    }

}();

window.addEventListener('load', function() {
    RoboconPanel.initialize();
});