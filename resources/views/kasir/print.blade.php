<script>
    var url = <?php $url ?>;
    $.get(url, function (data) {
        window.location.href = data;
        window.close();
    }).fail(function () {
        alert("ajax error");
    });
</script>