$(function() {

    const received = function(data, status, xhr) {
        loaders(false);
        $('#project-container').html(data);
    }

    const error = function(request, status, error) {
        console.log(error);
        loaders(false);
    }

    window.addEventListener('load', function() {
        loaders(true);

        const project_id = window.location.href.split("/").pop();

        var docLoaded = false;
        firebase.database().ref('projects').orderByChild('id').equalTo(project_id).on('value', function(snap) {

            var obj = snap.val();
            var arr = null;
            
            try { 
                arr = Object.keys(obj).map(function (key) { return obj[key]; })[0];
            } catch(error) { }

            if(docLoaded) loaders(true);

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
            loaders(false);
            console.log(error);
        });
    });
});