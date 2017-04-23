var ProjectPanel = function () {
    const received = function(data) {
        App.showProgressBar(false);
        $('#project-container').html(data);
        $('.materialboxed').materialbox();
        $('.tooltipped').tooltip();
    };

    const error = function(request, status, error) {
        console.log(error);
        App.showProgressBar(false);
    };

    return {
        initialize: function () {
            App.showProgressBar(true);

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

                    if(docLoaded) App.showProgressBar(true);

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
                App.showProgressBar(false);
                console.log(error);
            });
        }
    }
}();

window.addEventListener('load', function() {
    ProjectPanel.initialize();
});