<div class="mb-3">
    <h4 class="mb-3">{{ translate('Endpoint') }}</h4>
    <div class="code">
        <div class="copy">
            <i class="far fa-clone"></i>
        </div>
        <code>
            <pre class="mb-0"><div class="method get">GET</div><div class="endpoint copy-data">{{ route('api.items.all') }}</div></pre>
        </code>
    </div>
</div>
<div class="mb-3">
    <h4 class="mb-3">{{ translate('Parameters') }}</h4>
    <ul>
        <li><strong>api_key</strong>: {{ translate('Your API key') }}
            <code>({{ translate('required') }})</code>
        </li>
    </ul>
</div>
<div class="mb-3">
    <h4 class="mb-3">{{ translate('Responses') }}</h4>
    <p><strong>{{ translate('Success Response') }}:</strong></p>
    <div class="code">
        <code>
            <pre class="mb-0 text-success">{
    "status": "success",
    "items": [
        {
            "id": 1534268,
            "name": "Lorem Ipsum - simply dummy text of the printing",
            "description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry...."
            "category": "Themes",
            "sub_category": "WordPress", // {{ translate('This will be null when its not exists') }}
            "options": {
                // {{ translate('Item options here...') }}
            },
            "version": "1.0.0",
            "demo_link": "https://example.com",
            "tags": "Lorem, Ipsum, Listings, simply, dummy, etc...",
            "media": {
                "thumbnail": "https://example.com/thumbnail.png",
                "preview_image": "https://example.com/preview.jpg", // {{ translate('This is not included for audio items') }}
                "preview_video": "https://example.com/video.mp4", // {{ translate('This is only included for video items') }}
                "preview_audio": "https://example.com/audio.mp3", // {{ translate('This is only included for audio items') }}
                "screenshots": {
                    "0": "http://example.com/screenshot1.png",
                    "1": "http://example.com/screenshot2.png",
                }
            },
            "prices": { // {{ translate('This will be null when the item is free') }}
                "regular": 49,
                "extended": 199 // {{ translate('This will not exists if the item has no extended license') }}
            },
            "currency": "{{ @$settings->currency->code }}", {{ translate('This will be null when the item is free') }}
            "last_update_at": "2024-09-27 13:53:47",
            "published_at": "2024-09-22T05:02:13.000000Z"
        },
        {
            // Next item...
        }
    ]
}</pre>
        </code>
    </div>
</div>
<div>
    <p><strong>{{ translate('Error Response') }}:</strong></p>
    <div class="code mb-3">
        <code>
            <pre class="mb-0 text-danger">{
    "status": "error",
    "msg": "{{ translate('No Items Found') }}"
}</pre>
        </code>
    </div>
</div>
