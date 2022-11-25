    <div class="mt-2">
        <form id="new-post-form" method="post" action="/api/posts/{{$slot}}/comments">
            @csrf
            <label for="text" class="">Добавить новый комментарий</label>
            <div class="clearfix"></div>
            <x-bb-code>#text</x-bb-code>
            <textarea class="min-w-full h-32" name="body" id="text" placeholder="Текст комментария" required></textarea>
            <div class="clearfix"></div>
            <button class="w-auto border-2 rounded-full px-2" type="submit">Отправить</button>
            <button class="w-auto border-2 rounded-full px-2" type="button" id="preview">Предварительный просмотр
            </button>
        </form>
        <x-bb-code-preview>#text</x-bb-code-preview>
    </div>
    <script type="module">
        $("#new-post-form").validate({
            rules: {
                title: {required: true},
                body: {required: true},
            },
            messages: {
                title: "Введите тему поста",
                body: "Введите текст поста",
            }
        });
        $("#new-post-form").submit(function (e){
            let form = $(this);

            e.preventDefault();

            if (form.valid())
            {
                axios.post(form.attr('action'),form.serialize())
                    .then(result=>result.data)
                    .then(result=>{
                        let postId = result.data.post_id;
                        document.location.href = document.location.origin + "/posts/" + postId + "/comments";
                    });
            }
            return false;
        })
    </script>
