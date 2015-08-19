window.onload = function() {
    document.getElementById('send_request').onclick = function() {
        var connect, user, pass, email, form, session, result;
        user = document.getElementById('user').value;
        pass = document.getElementById('pass').value;
        email = document.getElementById('email').value;
        form = 'user=' + user + '&pass=' + pass + '&email=' + email;
        if(user != '' && pass != '' && email != '') {
            connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            connect.onreadystatechange = function() {
                if(connect.readyState == 4 && connect.status == 200) {
                    if(parseInt(connect.responseText) == 1) {
                        result = 'Accediendo...';
                        document.getElementById('_AJAX_').innerHTML = result;
                        window.location = '?core=overview';
                    } else  {
                        document.getElementById('_AJAX_').innerHTML = connect.responseText; 
                    }
                } else if(connect.readyState != 4) {
                   result = 'Cargando...';
                   document.getElementById('_AJAX_').innerHTML = result; 
                }
            }
            connect.open('POST','?core=index&mode=reg',true);
            connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            connect.send(form);
        } else {
            result = 'ERROR: Campos vacíos.';
            document.getElementById('_AJAX_').innerHTML = result;
        }
    }
}