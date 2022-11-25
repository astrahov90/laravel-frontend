<x-app-layout>
    <div class="loaderBody bg-light">
        <div id="loader"></div>
    </div>
    <label class="morePosts">Еще...</label>

    <script type="module">
        let morePostsBtn = $(".morePosts");

        morePostsBtn.hide();

        $(".card-read-more-button").click(function (e) {
            if ($("#" + $(this).attr("for")).is(":not(:checked)")) {
                scrollIntoViewIfNeeded($(e.target));
            }
        });

        $(document).ready(function () {
            loadPostsData(false);
        });

        morePostsBtn.click(function () {
            loadPostsData();
        });

        $('body').on('click','.rating-arrow', function () {
            let curPostId;

            if (typeof postId !== 'undefined')
            {
                curPostId = postId;
            }
            else
            {
                curPostId = $(this).closest(".row.post").find('.postId').val();
            }

            let like = true;
            if ($(this).hasClass('rating-down')){
                like = false;
            }

            let ratingField = $(this).closest('.row').find('.rating-count');

            ratePost(curPostId, like, ratingField);

            return false;
        });

    </script>
</x-app-layout>
