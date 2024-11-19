<script>
    "use strict";
    const config = {!! json_encode([
        'url' => url('/'),
        'lang' => getLocale(),
        'direction' => getDirection(),
        'colors' => $themeSettings->colors,
        'translates' => [
            'copied' => translate('Copied to clipboard'),
            'actionConfirm' => translate('Are you sure?'),
            'noneSelectedText' => translate('Nothing selected'),
            'noneResultsText' => translate('No results match'),
            'countSelectedText' => translate('{0} of {1} selected'),
        ],
    ]) !!};
</script>
