window.onload = function() {
    document.getElementById('send_request').onclick = function() {
        var connect, user, pass, form, session, result;
        user = document.getElementById('user').value;
        pass = document.getElementById('pass').value;
        session = document.getElementById('session').checked ? true : false;
        form = 'user=' + user + '&pass=' + pass + '&session=' + session;
        if(user != '' && pass != '') {
            connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            connect.onreadystatechange = function() {
                if(connect.readyState == 4 && connect.status == 200) {
                    if(parseInt(connect.responseText) == 1) {
                        result = 'Accediendo...';
                        document.getElementById('_AJAX_').innerHTML = result;
                        window.location = '?core=overview';
                    } else {
                        result = 'ERROR: Datos incorrectos.';
                        document.getElementById('_AJAX_').innerHTML = result; 
                    }
                } else if(connect.readyState != 4) {
                   result = 'Cargando...';
                   document.getElementById('_AJAX_').innerHTML = result; 
                }
            }
            connect.open('POST','?core=index&mode=login',true);
            connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            connect.send(form);
        } else {
            result = 'ERROR: Campos vacíos.';
            document.getElementById('_AJAX_').innerHTML = result;
        }
    }
}