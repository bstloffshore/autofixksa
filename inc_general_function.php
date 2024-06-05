<?Php

function getLangText( $keyword ) {
    global $db;
    $res = $db->query( "SELECT * FROM translations WHERE keyword = ?s", $keyword );

    if ( $_SESSION['lang'] == 'en' ) {
        return $row = mysqli_fetch_assoc( $res )['english'];
    } else {
        return $row = mysqli_fetch_assoc( $res )['arabic'];
    }


}