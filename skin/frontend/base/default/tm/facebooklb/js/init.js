document.observe("dom:loaded", function() {

    function initObservers(){
        $$('.fbl-custom .like').each(function(el){
            if (el.hasClassName('initialized')) { return; }
            el.observe('click', function(e){
                // variable 'this' - element with the observer
                // call fb dialog to like product
                FB.ui({
                  method: 'share_open_graph',
                  action_type: 'og.likes',
                  action_properties: JSON.stringify({
                    object: this.getAttribute('data-url'),
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

    if (typeof FB === 'undefined') {
        // set callback on facebook SDK load
        if (window.fbAsyncInit) {
            window.fbAsyncInit = window.fbAsyncInit.wrap(function (callOriginal){
                callOriginal();
                facebookButtonsInit();
            });
        } else {
            window.fbAsyncInit = facebookButtonsInit;
        }
        // load Facebook SDK
        var ogLocale = $$('meta[property="og:locale"]').first();
        var locale = ogLocale.hasAttribute('content')
                ? ogLocale.getAttribute('content') : 'en_US';
        $$('script').first().insert({
            'before': new Element('script', {
                'src': "//connect.facebook.net/"+locale+"/sdk.js",
                'id': 'facebook-jssdk'
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
            document.observe(eventName, function(){
                FB.XFBML.parse();
                initObservers();
            });
        }
    );
});
