(function($) {
    $(document).ready(function() {
        $("#compare").click(function(e) {
            var first = $('#first').val();
            var second = $('#second').val();
            var format = /\w+\/\w+/;
            var first_slash_count = (first.match(/\//g) || []).length;
            var second_slash_count = (second.match(/\//g) || []).length;
            if(first.match(format) && second.match(format) && first_slash_count == 1 && second_slash_count == 1) {
                var rest_url = "/public/api/compare/" + first + "/" + second;
                $("#result").html('<img alt="Loading.." src="/public/ajax-loader.gif" />');
                $.ajax({
                    type: "GET",
                    url: rest_url,
                    success: function(data) {
                        $("#result").html(
                            '<div class="box"><ul><li>' + data.repo1.full_name + '</li><li>Forks: ' + data.repo1.forks_count + '</li><li>Stars: ' + data.repo1.stargazers_count + '</li><li>Watchers: ' + data.repo1.subscribers_count + '</li><li>Latest release: ' + data.repo1.pushed_at + '</li><li>Open pulls: ' + data.repo1.open_pulls + '</li><li>Closed pulls: ' + data.repo1.closed_pulls + '</li></ul></div>' + 
                            '<div class="box"><ul><li>' + data.repo2.full_name + '</li><li>Forks: ' + data.repo2.forks_count + '</li><li>Stars: ' + data.repo2.stargazers_count + '</li><li>Watchers: ' + data.repo2.subscribers_count + '</li><li>Latest release: ' + data.repo2.pushed_at + '</li><li>Open pulls: ' + data.repo2.open_pulls + '</li><li>Closed pulls: ' + data.repo2.closed_pulls + '</li></ul></div>' +
                            '<div class="box"><ul><li>Comparison</li><li>Popularity: ' + data.comparison.diff_popularity + '</li><li>Activity: ' + data.comparison.diff_activity + '</li><li>Size: ' + data.comparison.diff_size + '</li></ul></div>'
                        );
                    },
                    error: function(err) {
                        $("#result").text("API Error");
                    }
                });
            }
            else {
                $("#result").text("Invalid format! Try organisation/repository.");
            }
        });
    });
})(jQuery);
