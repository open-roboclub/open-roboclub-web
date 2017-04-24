var NewsPanel = function () {

    var newsTemplate = doT.template(
        '<div class="card">\
            <div class="card-content">\
                <div class="row">\
                    <div class="col m1 s2">\
                        <i class="mdi mdi-newspaper mdi-36px grey-text text-darken-2" aria-hidden="true"></i>\
                    </div>\
                    <div class="col m11 s10">\
                        <div class="white-space-pre">{{= it.notice }}</div>\
                        <div class="divider margin-small"></div>\
                        <div><em> {{= it.date }} </em></div>\
                    </div>\
                </div>\
            </div>\
            {{? it.link }}\
                <div class="card-content grey lighten-3 link-box" style="padding: 10px">\
                    <a href="{{= it.link }}" style="text-decoration : none;" target="_blank">\
                        <div class="valign-wrapper">\
                            <i class="material-icons padding-small">link</i>\
                            <span class="padding-small">View attached link</span>\
                        </div>\
                    </a>\
                </div>\
            {{?}}\
     </div>');


    var loaded = false;

    function addNews(news, key) {
        const newsPanel = $('#news-panel');
        if (!loaded) {
            App.showProgressBar(false);
            newsPanel.html('');
            loaded = true;
        }

        newsPanel.prepend('<div id="' + key + '" >' + newsTemplate(news) + '</div>');
    }

    function changeNews(news, key) {
        $('#' + key).html(newsTemplate(news));
    }

    function removeNews(key) {
        $('#' + key).remove();
    }

    return {
        initialize: function () {
            App.showProgressBar(true);

            var newsRef = FirebaseOps.getDatabaseReference('news');
            newsRef.on('child_added', function (snapshot) {
                addNews(snapshot.val(), snapshot.key);
            });

            newsRef.on('child_changed', function (snapshot) {
                changeNews(snapshot.val(), snapshot.key);
            });

            newsRef.on('child_removed', function (snapshot) {
                removeNews(snapshot.key);
            });
        }
    }

}();

window.addEventListener('load', function () {
    NewsPanel.initialize();
});

