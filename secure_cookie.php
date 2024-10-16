<?php
    // セッションを始める前に、毎回クッキーの設定を行う
    // PHP のバージョンによって設定方法が異なる場合があるので注意
    session_set_cookie_params(3600,'','',true,true);

    // クッキーの状態確認
    $params = session_get_cookie_params();
    echo "クッキーの生存期間(lifetime)：" . $params["lifetime"] . "<br>";
    echo "クッキーのパス(path)：" . $params["path"] . "<br>";
    echo "クッキーのドメイン(domain)：" . $params["domain"] . "<br>";
    echo "クッキーのセキュア属性(secure)：";
    echo var_export($params["secure"]) . "<br>";
    echo "クッキーのhttponly属性(httponly)：";
    echo var_export($params["httponly"]) . "<br>";
?>