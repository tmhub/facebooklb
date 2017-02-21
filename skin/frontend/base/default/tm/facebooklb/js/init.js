document.observe("dom:loaded", function() {
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        var locale = $('fb-root').hasAttribute('data-locale')
            ? $('fb-root').getAttribute('data-locale') : 'en_US';
        js.src = "//connect.facebook.net/"+locale+"/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});
