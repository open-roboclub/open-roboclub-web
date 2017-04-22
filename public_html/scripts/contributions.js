var ContributionPanel = function () {
    var contributionTemplate = doT.template(
        '<div class="col l3 m4 s12">\
            <div class="card-panel hoverable">\
                <div style="height: 230px;">\
                        <div class="center-align">\
                            <i class="mdi mdi-coin mdi-48px amber-text" aria-hidden="true"></i><br>\
                            <div class="member-name"><strong>{{= it.amount }}</strong></div><br>\
                            <span class="member-position">{{= it.contributor }}</span><br>\
                        </div><br>\
                        <div><em><strong>Purpose : &nbsp;</strong></em> {{= it.purpose }}</div>\
                        <div><em><strong>Remark : &nbsp;</strong></em> {{= it.remark }}</div>\
                </div>\
            </div>\
        </div>');

    var loaded = false;
    function addContribution(contribution, key) {
        if(!loaded) {
            App.showProgressBar(false);
            loaded = true;
        }

        $('#contributions').prepend('<div id="' + key + '" >' + contributionTemplate(contribution) + '</div>');
    }

    function changeContribution(contribution, key) {
        $('#'+key).html(contributionTemplate(contribution));
    }

    function removeContribution(key) {
        $('#'+key).remove();
    }

    return {
        initialize: function () {
            App.showProgressBar(true);

            var newsRef = FirebaseOps.getDatabaseReference('contribution');
            newsRef.on('child_added', function(snapshot) {
                addContribution(snapshot.val(), snapshot.key);
            });

            newsRef.on('child_changed', function(snapshot) {
                changeContribution(snapshot.val(), snapshot.key);
            });

            newsRef.on('child_removed', function(snapshot) {
                removeContribution(snapshot.key);
            });
        }
    }
}();

window.addEventListener('load', function () {
    ContributionPanel.initialize();
});

