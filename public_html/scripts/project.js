var ProjectPanel = function () {
    const received = function(data) {
        App.showProgressAndAnimation(false);
        $('#project-container').html(data);
        $('.materialboxed').materialbox();
    };

    const error = function(request, status, error) {
        console.log(error);
        App.showProgressAndAnimation(false);
    };

    return {
        initialize: function () {
            App.showProgressAndAnimation(true);

            const project_id = window.location.href.split("/").pop();

            var docLoaded = false;
            FirebaseOps.getDatabaseReference('projects')
                .orderByChild('id')
                .equalTo(project_id)
                .on('value', function(snap) {

                    var obj = snap.val();
                    var arr = null;

                    try {
                        arr = Object.keys(obj).map(function (key) { return obj[key]; })[0];
                    } catch(error) {
                        console.log(error);
                    }

                    if(docLoaded) App.showProgressAndAnimation(true);

                    docLoaded = true;

                    $.ajax(
                        {
                            type: 'POST',
                            url: base_url + '/projects/template',
                            data: arr,
                            success: received,
                            error: error
                        }
                    );

            }, function(error) {
                App.showProgressAndAnimation(false);
                console.log(error);
            });
        }
    }
}();

window.addEventListener('load', function() {
    ProjectPanel.initialize();
});