<script>
    "use strict";
    const config = {!! json_encode([
        'url' => url('/'),
        'admin_url' => adminUrl(),
        'lang' => getLocale(),
        'direction' => getDirection(),
        'colors' => @$settings->system_admin->colors,
        'translates' => [
            'copied' => translate('Copied to clipboard'),
            'actionConfirm' => translate('Are you sure?'),
            'emptyTable' => translate('No data available in table'),
            'searchPlaceholder' => translate('Start typing to search...'),
            'sLengthMenu' => translate('Rows per page _MENU_'),
            'info' => translate('Showing page _PAGE_ of _PAGES_'),
            'infoEmpty' => translate('Showing 0 to 0 of 0 entries'),
            'infoFiltered' => translate('(filtered from _MAX_ total entries)'),
            'zeroRecords' => translate('No matching records found'),
            'paginate' => [
                'first' => translate('First'),
                'previous' => translate('Previous'),
                'next' => translate('Next'),
                'last' => translate('Last'),
            ],
            'on' => translate('Active'),
            'off' => translate('Disabled'),
            'noneSelectedText' => translate('Nothing selected'),
            'noneResultsText' => translate('No results match'),
            'countSelectedText' => translate('{0} of {1} selected'),
        ],
    ]) !!}
</script>
