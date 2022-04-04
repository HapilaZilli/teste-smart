<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <div class="search_container">
            <div class="searchbox_container">
                <input id="query_input" type="text" placeholder="Nome de Usuário"></input>
                <button onclick="query()"><img src="/smart/images/lupa_branca.png" style="width: 12px; height: 12px;"></button>
            </div>
            <div class="result_container">
                <p id="query_name_p" style="color: rgb(196, 196, 196);"></p>

                <div id="list_container" class="list_container">
                    <div id="list" class=list>
   
                    </div>
                    
            </div> 
        </div>
    </div>
    <script>
        function add_list_item(repo_url, repo_name, repo_desc, full_name, repo_created_at, repo_language){
            let url_downloads = "https://api.github.com/repos/"+full_name+"/releases"

            $.get(url_downloads, function(download_data){
                try {
                    repo_downloads = download_data[0]["assets"][0]["download_count"]

                } catch {
                    repo_downloads = "0"

                }
                    
                let list_item = `<a href="`+repo_url+`" style="text-decoration: none; color: black;">
                                <div class=list_table_item>
                                    <div class=list_table_item_inner>
                                        <td>
                                            <p style="display: inline-block; padding-left: 20px; vertical-align: middle;">`+repo_name+`</p>
                                        </td>
                                    </div>
                                    <div class=list_table_item_inner>
                                        <td>
                                            <p style="display: inline-block; padding-left: 5px; vertical-align: middle;">`+repo_desc+`</p>
                                        </td>
                                    </div>
                                    <div class=list_table_item_inner>
                                        <td style="display: inline-block;">
                                            <img src="/smart/images/seta-para-download.png" style="width: 20px; height: 20px; vertical-align: middle;">
                                            <p style="display: inline-block; padding-left: 5px; vertical-align: middle;">`+repo_downloads+`</p>
                                        </td>
                                    </div>
                                    <div class=list_table_item_inner>
                                        <td>
                                            <p style="display: inline-block; padding-left: 5px; vertical-align: middle;">`+repo_created_at+`</p>
                                        </td>
                                    </div>
                                    <div class=list_table_item_inner>
                                        <td>`+repo_language+`</td>
                                    </div>
                                </div>
                            </a>`
                let list = document.getElementById("list").insertAdjacentHTML("afterbegin", list_item)
        })
        }
        function mode(arr){
            return arr.sort((a,b) =>
                arr.filter(v => v===a).length
                - arr.filter(v => v===b).length
            ).pop()
        }


        function format_json(data, status){
            let query = document.getElementById("query_input").value
            var programming_languages = []
            var repo_count = 0
            if (data.length != 0){
                for (var repo in data){
                    repo_count += 1
                    let repo_url = data[repo]["clone_url"]
                    let full_name = data[repo]["full_name"]

                    let repo_name
                    let repo_name_f = data[repo]["name"]
                    if (repo_name_f.length > 12){
                        repo_name = repo_name_f.slice(0,12)+"..."
                    }else{
                        repo_name = repo_name_f
                    }

                    let repo_desc
                    let repo_desc_f = data[repo]["description"]
                    if (repo_desc_f){
                        if (repo_desc_f.length > 25) {
                            repo_desc = repo_desc_f.slice(0,25)+"..."
                        }else{
                            repo_desc = repo_desc_f
                        }
                    }else{
                        repo_desc = "Sem descrição"
                    }

                    let repo_created_at_f = data[repo]["created_at"]
                    let repo_created_at = repo_created_at_f.slice(0,10)

                    let repo_language = data[repo]["language"]
                    if (!repo_language) {
                        repo_language = "Sem predominante"
                    }

                    programming_languages.push(repo_language)


                    add_list_item(repo_url, repo_name, repo_desc, full_name, repo_created_at, repo_language)
                }

                let user_predominant_language = mode(programming_languages)
                user_url = "https://api.github.com/users/"+query
                    $.get(user_url, function(data){
                        let user_avatar = data["avatar_url"]
                        let user_name = query
                        let user_url = data["html_url"]
                        let user_followers = data["followers"]
                        let user_last_seen = data["updated_at"]

                        update_history_url = "/smart/history_add.php?user_avatar="+user_avatar+"&user_name="+user_name+"&user_repos_count="+repo_count+"&user_url="+user_url+"&user_followers="+user_followers+"&user_last_seen="+user_last_seen+"&user_predominant_language="+user_predominant_language
                        $.get(update_history_url)
                    })
                

            }else{
                document.getElementById("list").innerHTML = `<div id="no-history" class="no-history">
                    <h1>Oops!</h1>
                    <h2>Parece que este usuário não possui repos 🥺</h2>
                    <p>Tente conferir o nome de usuário e tente novamente</p>
                </div>`
            }
        }

        function query(){
            let query = document.getElementById("query_input").value
            if (query){
                document.getElementById("query_name_p").innerHTML = "Mostrando os resultados para: " + query

                let url = "https://api.github.com/users/"+ query +"/repos"


                document.getElementById("list").innerHTML = ""


                $.get(url, format_json)
                }
            }

    </script>
</body>
</html>