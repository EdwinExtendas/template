export default {
    getCookie: function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    },
    setCookie: function(cname, cvalue, exdays) {
        if(exdays){
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
        }
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    unsetCookie: function(cname) {
        this.setCookie(cname,'',-1);
    },
    logout: function () {
        this.unsetCookie('user');
        return true;
    },
    getUserCookie: function() {
        return this.checkLogin() ? JSON.parse(atob(this.getCookie('user'))) : false;
    },
    checkLogin: function() {
        return (this.getCookie('user').length > 0);
    },
    checkAdmin: function() {
        return this.checkLogin() ? (this.getUserCookie()).admin : false;
    }
}
