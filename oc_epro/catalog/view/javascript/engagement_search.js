//Engagement PRO Search
$(document).ready(function() {
    $('input[name="search"]').on('blur', function() {
        var query = $(this).val();
        saveQuery(query);
    });
    $('input[name="search"]').keypress(function (e) {
        var key = e.which;
        if (key === 13 ) {
            var query = $(this).val();
            saveQuery(query);
        }
    });
    function saveQuery(query){
        if (query.length !== 0) {
            $.ajax({
                type: "POST",
                url: "index.php?route=account/engagement_pro/addSearch",
                dataType: "json",
                data: ({search: query}),
            });
        }
    }
});
