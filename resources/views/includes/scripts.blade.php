<script>
    $(document).ready(function() {
        hideSelectors();

        $('input[type=radio][name=redirect_type]').change(function() {
            hideSelectors();
            if($("#custom_url").is(':checked')) {
                $('#custom_url_selector').show();
            }
            if($("#product").is(':checked')) {
                $('#product_url_selector').show();
            }
        });

        function hideSelectors() {
            $('#custom_url_selector').hide();
            $('#product_url_selector').hide();
        }
    });
</script>