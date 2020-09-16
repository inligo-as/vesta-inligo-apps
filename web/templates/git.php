<div class="units l-center vestacp-web-apps">
    <form action="index.php" method="post">
        <h1><?= __("Create git repository") ?></h1>
        <p><em>Create a bare git repository with <strong>post-receive</strong> hook for a domain.</em></p>

        <select name="web_domain" class="vst-list" required>
            <option value=""><?= __("Select a web domain") ?></option>
            <?php
            $users = Vesta::exec("v-list-users", "json");
            ksort($users);

            $configs = [];

            foreach ($users as $user_name => $value) {
                $web_domains = Vesta::exec("v-list-web-domains", $user_name, "json");
                ksort($web_domains);

                foreach ($web_domains as $web_domain => $domain_data) {
                    if ($user == 'admin' || $user == $user_name) {
                        $display_name = ($_SESSION['user'] == 'admin') ? "$user_name - $web_domain" : "$web_domain";

                        echo "<option value=\"$user_name|$web_domain\">$display_name</option>";
                    }
                }
            }
            ?>
        </select>
        <br><br>
        <label for="source_path">
            Source path (relative from home directory):<br>
            <input type="text" id="source_path" name="source_path" size="50" required/><br><br>
            <strong>Wordpress</strong>: <pre>web/DOMAIN/public_html/wp-content/themes/THEME</pre>
            <strong>Other</strong>: <pre>web/DOMAIN/app</pre>
        </label>
        <br>
        <label for="deploy_cmd">
            Deployment command: (optional)<br>
            <input type="text"  id="deploy_cmd" name="deploy_cmd" size="50" placeholder="./deploy"/><br>
            <em>Specify a command executed from inside SOURCE_PATH</em>
        </label>
        <br><br>
        <input type="hidden" name="action" value="create_git_repo" />
        <button class="button confirm" type="submit"><?= __("Create") ?></button>
    </form>
</div>