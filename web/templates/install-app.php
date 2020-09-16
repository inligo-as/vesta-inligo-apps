<!-- Install app -->
<form action="index.php" method="post" style="margin-bottom: 30px;">
    <h1><?= __("Install a web-app") ?></h1>

    <select name="app" class="vst-list" required>
        <option value=""><?= __("Select an app") ?></option>
        <option value="wordpress">Wordpress</option>
    </select>
    <br><br>

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

    <input type="hidden" name="action" value="install" />
    <button class="button confirm" type="submit"><?= __("Install") ?></button>
</form>