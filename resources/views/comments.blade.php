<x-app-layout>

    <div class="loaderBody bg-light">
        <div id="loader"></div>
    </div>
    <div class='row post'>
        <!-- load post info -->
    </div>
    <div class='clearfix'></div>
    <div class="row mt-2 hasComments hidden">
        <div class="w-12 font-bold">Комментарии пользователей:</div>
    </div>
    <label class="moreComments hidden">Еще...</label>
    @if (Auth::check())
        <x-new-comment>{{$post_id}}</x-new-comment>
    @else
        <span>Для добавления комментария необходимо </span><a href="/login">авторизоваться</a>
    @endif

    <script type="module">
        let postId = "{{$post_id}}";

        let moreCommentsBtn = $(".moreComments");
        moreCommentsBtn.hide();

        let hasComments = $(".hasComments");
        hasComments.hide();

        let previewData = $("#preview-data");
        previewData.hide();

        let commentField = $("#comment");

        $(".card-read-more-button").click(function (e) {
            if ($("#" + $(this).attr("for")).is(":not(:checked)")) {
                scrollIntoViewIfNeeded($(e.target));
            }
        });

        $("#preview").click(function () {
            previewData.show();
            previewData.find('pre').html(bbCodeDecode($("#comment").val()));
        });

        $(document).ready(function () {
            loadPostInfo(postId);
            loadCommentsData(postId);
        });

        moreCommentsBtn.click(function () {
            loadCommentsData(postId);
        });

        $(".bbcode").click(function () {
            let curText = commentField.val();

            let curSelectionStart = commentField.prop('selectionStart');
            let curSelectionEnd = commentField.prop('selectionEnd');

            let tag;
            let url;
            let color;

            switch ($(this).attr('id')) {
                case "text-bold":
                    tag = 'b';
                    break;
                case "text-italic":
                    tag = 'i';
                    break;
                case "text-underline":
                    tag = 'u';
                    break;
                case "text-line-through":
                    tag = 's';
                    break;
                case "text-quote":
                    tag = 'quote';
                    break;
                case "text-url":
                    tag = 'url';
                    break;
                case "text-img":
                    tag = 'img';
                    break;
                case "text-color":
                    tag = 'color';
                    break;
            }

            if (tag === "url") {
                url = prompt("Введите url");
                if (!url) {
                    return false;
                }
            }

            if (tag === "img") {
                url = prompt("Введите ссылку на изображение");
                if (!url) {
                    return false;
                }
                curSelectionStart = curSelectionEnd;
            }

            if (tag === "color") {
                color = $("#text-color-select").val();
            }

            let curSelection = "[" + tag + (curSelectionStart !== curSelectionEnd && url ? "=" + url : "") + (color ? "='" + color + "'" : "") + "]" + (curSelectionStart === curSelectionEnd && url ? url : curText.slice(curSelectionStart, curSelectionEnd)) + "[/" + tag + "]";

            curText = curText.slice(0, curSelectionStart) + curSelection + curText.slice(curSelectionEnd);

            $("#comment").val(curText);
        });

    </script>
</x-app-layout>
