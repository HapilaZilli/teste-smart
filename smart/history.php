<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&amp;display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a src="www.github.com/"><img src="/smart/images/github_nav.png" alt="" style="width: 50px"></a>
        <nav>
            <ul class="nav_links">
               <li><a href="/smart/history.php">Histórico</a></li>
               <li><a href="/smart/dancingduck.php">Dancing Duck</a></li>
            </ul>
        </nav>
        <a href="/smart/index.php"><button>Pesquisar repositório</button></a>
    </header>

    <?php
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $json_file_path = "/var/www/html/smart/history/".$client_ip.".json"; 
    if (is_file($json_file_path)){
        $array = json_decode(file_get_contents($json_file_path), true);
        echo '<div class="list_container">
        <div class=list>';
        foreach ($array as $user_search){
            $user_avatar = $user_search["user_avatar"];
            $user_name = $user_search["user_name"];
            $user_repos_count = $user_search["user_repos_count"];
            $user_url = $user_search["user_url"];
            $user_followers = $user_search["user_followers"];
            $user_last_seen = $user_search["user_last_seen"];
            $user_predominant_language = $user_search["user_predominant_language"];

            $current_date = date('Ymd');

            $active_rgb = "rgb(153, 255, 127)";
            $not_active_rgb = "rgb(224,224,224)";

            // 2022-02-01T18:45:13Z
            
            $user_last_seen = substr($user_last_seen, 0, 10);
            // 2022-02-01
            $user_last_seen = str_replace("-","",$user_last_seen);
            // 20220201

            $diference = $current_date - $user_last_seen;

            if ($diference < 200){
                $user_rgb = $active_rgb;
            }else{
                $user_rgb = $not_active_rgb;
            }

            echo '<a href="'.$user_url.'" style="text-decoration: none; color: black;">
            <div class=list_table_item>
                <div class=list_table_item_inner>
                    <td>
                        <img src="'.$user_avatar.'" style="border-radius: 50%; width: 20px; height: 20px; vertical-align: middle;">
                        <p style="display: inline-block; padding-left: 20px; vertical-align: middle;">'.$user_name.'</p>
                    </td>
                </div>
                <div class=list_table_item_inner>
                    <td>
                        <img src="/smart/images/repositories.png" style="width: 20px; height: 20px; vertical-align: middle;">
                        <p style="display: inline-block; padding-left: 5px; vertical-align: middle;">'.$user_repos_count.'</p>
                    </td>
                </div>
                <div class=list_table_item_inner>
                    <td style="display: inline-block;">
                        <img src="/smart/images/followers.png" style="width: 30px; height: 30px; vertical-align: middle;">
                        <p style="display: inline-block; padding-left: 5px; vertical-align: middle;">'.$user_followers.'</p>
                    </td>
                </div>
                <div class=list_table_item_inner style="display: flex; justify-content: center;">
                    <td>
                        <div style="border-radius: 50%; background-color: '.$user_rgb.'; width: 20px; height: 20px;">
                        </div>
                    </td>
                </div>
                <div class=list_table_item_inner style="text-align: center;">
                    <td>'.$user_predominant_language.'</td>
                </div>
            </div>
        </a>';
        }
        echo '</div>
        </div>';



    }else{
        $no_history = '<div class="no_history_container">
        <div class="no-history">
            <h1>Oops!</h1>
            <h2>Parece que você não realizou nenhuma consulta ainda 🥺</h2>
            <p>Para realizar sua primeira consulta, <a href="/smart/index.php">clique aqui</a> ou acesse a página de consulta pelo botão "Pesquisar repositório" na barra de nagevcação.</p>
        </div>
    </div>';
        echo $no_history;
    }


    ?>
</body>
</html>