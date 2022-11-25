<div id="preview-data" class="hidden">
    <label class="font-bold" for="preview-data">Предпросмотр комментария</label>
    <pre class="h-32 bg-white border px-2">Предпросмотр</pre>
</div>

<script type="module">
    let previewData = $("#preview-data");
    previewData.hide();

    let textField = $("{{$slot}}");

    $("#preview").click(function () {
        previewData.show();
        previewData.find('pre').html(bbCodeDecode(textField.val()));
    });
</script>
