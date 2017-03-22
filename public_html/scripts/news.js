$(function(){
    var newsTemplate = doT.template(
    '<div class="panel panel-default">\
        <div class="panel-body">\
            <i class="mdi mdi-newspaper mdi-36px vcenter" aria-hidden="true"></i>\
            <div class="vcenter news-notice white-space-pre" >{{= it.notice }}</div>\
            <div class="news-date"><em> {{= it.date }} </em></div>\
        </div>\
        {{? it.link }}\
        <a href="{{= it.link }}" style="text-decoration : none;" target="_blank">\
            <div class="panel-footer" id="newspanel-footer">\
                <i class="mdi mdi-link mdi-24px vertical-ali pr-5" aria-hidden="true"></i> View attached link\
            </div>\
        </a>\
        {{?}}\
    </div>');

    var loaded = false;
    function addNews(news, key) {
        if(!loaded) {
            progress(false);
            loaded = true;
        }

        $('#news-panel').prepend('<div id="' + key + '" >' + newsTemplate(news) + '</div>');
    }

    function changeNews(news, key) {
        $('#'+key).html(newsTemplate(news));
    }

    function removeNews(key) {
        $('#'+key).remove();
    }

    window.addEventListener('load', function() {
        loadingAnimation(false);
        progress(true);

        var newsRef = firebase.database().ref('news');
        newsRef.on('child_added', function(snapshot) {
            addNews(snapshot.val(), snapshot.key);
        });

        newsRef.on('child_changed', function(snapshot) {
            changeNews(snapshot.val(), snapshot.key);
        });

        newsRef.on('child_removed', function(snapshot) {
            removeNews(snapshot.key);
        });

    });
});
