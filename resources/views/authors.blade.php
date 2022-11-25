<x-app-layout>
    <div class="loaderBody bg-light">
        <div id="loader"></div>
    </div>
    <label class="moreAuthors">Еще...</label>

    <script type="module">
        let moreAuthorsBtn = $(".moreAuthors");
        moreAuthorsBtn.hide();

        $(document).ready(function () {
            loadAuthorsListData();
        });

        moreAuthorsBtn.click(function () {
            loadAuthorsListData();
        });

    </script>
</x-app-layout>
