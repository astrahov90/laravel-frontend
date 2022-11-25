<div class="btn-group mt-2 mb-2" role="group">
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-bold" title="Полужирный"><span
            style="font-weight: bold">B</span></button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-italic" title="Курсив"><span
            style="font-style: italic">I</span></button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-underline"
            title="Подчеркнутый"><span style="text-decoration: underline">U</span></button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-line-through"
            title="Зачеркнутый"><span style="text-decoration: line-through">S</span></button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-quote" title="Цитирование">
        <span style="font-weight: bold">""</span></button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-url" title="Гиперссылка">url
    </button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-img" title="Изображение">img
    </button>
    <button tabindex="-1" type="button" class="w-12 h-9 border-2 rounded-full bbcode" id="text-color" title="Цвет текста">
        color
    </button>
    <input tabindex="-1" type="color" class="w-12 h-9 border-2 rounded-full bbcode align-bottom" id="text-color-select" title="Цвет">
</div>

<script type="module">
    let bbCodeField = $("{{$slot}}");
    $(".bbcode").click(function () {
        let curText = bbCodeField.val();

        let curSelectionStart = bbCodeField.prop('selectionStart');
        let curSelectionEnd = bbCodeField.prop('selectionEnd');

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

        bbCodeField.val(curText);
    });
</script>
