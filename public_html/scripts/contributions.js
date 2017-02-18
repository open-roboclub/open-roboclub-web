$(function() {

    var contributionTemplate = doT.template(
'<div class="col-lg-3 col-md-4 col-sm-6">\
    <div class="panel panel-default">\
        <div class="panel-body text-size16" style="height: 380px;">\
            <div class="text-center">\
                <i class="mdi mdi-coin mdi-48px" style="color: #FFC107;" aria-hidden="true"></i>\
                <div class="text-size18"><strong>{{= it.amount }}</strong></div>\
                <br>\
                <div><em><strong>Contributors :</strong></em><br> {{= it.contributor }}</div>\
                <div><em><strong>Purpose :</strong></em><br> {{= it.purpose }}</div>\
                <div><em><strong>Remark :</strong></em><br> {{= it.remark }}</div>\
            </div>\
        </div>\
    </div>\
</div>');

    var loaded = false;
    function addContribution(contribution, key) {
        if(!loaded) {
            loaders(false);
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

    window.addEventListener('load', function () {
        loaders(true);

        var newsRef = firebase.database().ref('contribution');
        newsRef.on('child_added', function(snapshot) {
            addContribution(snapshot.val(), snapshot.key);
        });

        newsRef.on('child_changed', function(snapshot) {
            changeContribution(snapshot.val(), snapshot.key);
        });

        newsRef.on('child_removed', function(snapshot) {
            removeContribution(snapshot.key);
        });
    });

});

