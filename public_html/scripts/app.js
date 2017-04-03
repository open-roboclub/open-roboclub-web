const base_url = $('#base_url').text();

var App = function () {
    function toggleVisibility(show, view) {
        if (show) {
            view.style.display = 'block';
        } else {
            view.style.display = 'none';
        }
    }

    function toggleVisibilities(show, views) {
        for(var i = 0; i < views.length; i++) {
            toggleVisibility(show, views[i]);
        }
    }

    var progressCount = 0;
    const progressBar = document.getElementById('progress-bar');
    function progress(show) {

        if(show)
            progressCount++;
        else
            progressCount--;

        if(progressCount > 0)
            toggleVisibility(true, progressBar);
        else
            toggleVisibility(false, progressBar);
    }

    var loadingCount = 0;
    const loadingContainer = document.getElementById('loading-container');
    function loadingAnimation(show) {

        if(show)
            loadingCount++;
        else
            loadingCount--;

        if(loadingCount > 0)
            toggleVisibility(true, loadingContainer);
        else
            toggleVisibility(false, loadingContainer);
    }

    function loaders(show) {
        loadingAnimation(show);
        progress(show);
    }

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "2000"
    };

    function show(notification) {
        notification.css("top", 70);
    }

    function showError(error) {
        show(toastr.error(error));
    }

    const signinButton = $('#signin-button');
    const signinLink = $('#signin-link');

    return {
        toggleVisibility: toggleVisibility,
        toggleVisibilities: toggleVisibilities,
        showProgressBar: progress,
        showLoadingAnimation: loadingAnimation,
        showProgressAndAnimation: loaders,
        showToast: show,
        showErrorToast: showError,

        elements: {
            signinButton: signinButton,
            signinLink: signinLink
        }
    }
}();