document.observe("dom:loaded", function() {

    function initObservers(){
        $$('.fbl-custom-like').each(function(el){
            el.observe('click', function(e){
                var button = e.target;
                if (!button.hasClassName('fbl-custom-like')) {
                    button = button.up('.fbl-custom-like');
                }
                // call fb dialog to like product
                FB.ui({
                  method: 'share_open_graph',
                  action_type: 'og.likes',
                  action_properties: JSON.stringify({
                    object: button.getAttribute('data-url'),
                  })
                }, function(response){});
            });
            el.addClassName('initialized');
        });
    }

    function facebookButtonsInit() {
        var fbAppId = $$('meta[property="fb:app_id"]').first();
        FB.init({
            appId : fbAppId.getAttribute('content'),
            xfbml : true,
            version : 'v2.10'
        });
        initObservers();
    }

    // set callback on facebook SDK load
    if (window.fbAsyncInit) {
        window.fbAsyncInit = window.fbAsyncInit.wrap(function (callOriginal){
            callOriginal();
            facebookButtonsInit();
        });
    } else {
        window.fbAsyncInit = facebookButtonsInit;
    }

    var id = 'facebook-jssdk';
    if (typeof FB === 'undefined') {
        // load Facebook SDK
        var ogLocale = $$('meta[property="og:locale"]').first();
        var locale = ogLocale.hasAttribute('content')
                ? ogLocale.getAttribute('content') : 'en_US';
        $$('script').first().insert({
            'before': new Element('script', {
                'src': "//connect.facebook.net/"+locale+"/sdk.js",
                'id': id
                })
            }
        );
    } else {
        // SDK loaded; run init
        facebookButtonsInit();
    }

    // listen JS events
    ["ajaxlayerednavigation:ready", "quickshopping:previewloaded",
     "AjaxPro:onSuccess:after", "AjaxPro:onComplete:after"].map(
        function(eventName){
            document.observe(eventName, function(){FB.XFBML.parse()});
        }
    );
});
