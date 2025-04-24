<?php
// サーバーのIPアドレス（tack2427.aternos.meとtackruka.aternos.me）
$servers = [
    "tack2427.aternos.me" => "Tack2427 Minecraft Server",
    "tackruka.aternos.me" => "Tackruka Minecraft Server"
];

// HTMLヘッダー
echo "<!DOCTYPE html>";
echo "<html lang='ja'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Minecraft サーバー情報</title>";
echo "</head>";
echo "<body>";
echo "<h1>Minecraft サーバーオンライン状況</h1>";

foreach ($servers as $server_ip => $server_name) {
    // API URLを構築
    $api_url = "https://api.mcstatus.io/v2/status?host=" . $server_ip;

    // APIからデータを取得
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    // サーバー情報がオンラインかどうかを確認
    if ($data['online']) {
        echo "<h2>" . $server_name . "（" . $server_ip . "）</h2>";
        echo "サーバーはオンラインです。<br>";
        echo "バージョン: " . $data['version'] . "<br>";
        echo "プレイヤー数: " . $data['players']['online'] . " / " . $data['players']['max'] . "<br>";

        // サーバーアイコン
        echo "サーバーアイコン: <img src='" . $data['favicon'] . "' alt='サーバーアイコン' /><br>";

        // MOTDの表示
        echo "MOTD: <br>";
        foreach ($data['motd']['raw'] as $line) {
            echo $line . "<br>";
        }
    } else {
        echo "<h2>" . $server_name . "（" . $server_ip . "）</h2>";
        echo "サーバーはオフラインです。<br>";
    }
    echo "<hr>"; // サーバー情報間の区切り
}

// HTMLフッター
echo "</body>";
echo "</html>";
?>
