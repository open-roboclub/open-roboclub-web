$(function() {

    const received = function(data, status, xhr) {
        loaders(false);
        $('#project-container').html(data);
    }

    const error = function(request, status, error) {
        console.log(error);
        progress(false);
    }

    window.addEventListener('load', function() {
        progress(true);

        const project_id = window.location.href.split("/").pop();

        firebase.database().ref('projects').orderByChild('id').equalTo(project_id).on('value', function(snap) {
            progress(false);

            var obj = snap.val();
            var arr = null;
            
            try { 
                arr = Object.keys(obj).map(function (key) { return obj[key]; })[0];
            } catch(error) { }

            loaders(true);

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
            console.log(error);
        });
    });
});