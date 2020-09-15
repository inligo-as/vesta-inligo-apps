<?php
    
if (!class_exists('Vesta')) die('Vesta is not defined.'); 

// Read server name
exec(VESTA_CMD . "v-inligo-server-name get", $server_name);

$server_name = implode('', $server_name);

?>

<div class="l-center units vestacp-web-apps">
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

    <hr>

    <!-- Link up web domain with port --> 
    <form action="index.php" method="post" style="margin-bottom: 30px;">
        <h1><?= __("Set application port") ?></h1>
        <p><em>Remember to change nginx proxy after performing this action in domain settings.</em><p>
        
        <select name="web_domain" class="vst-list" required>
            <option value=""><?= __("Select a web domain") ?></option>
            <?php
            $web_domains = Vesta::exec("v-list-web-domains", $user, "json");
            ksort($web_domains);

            foreach ($web_domains as $web_domain => $domain_data) {
                echo "<option value=\"$user|$web_domain\">$web_domain</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="port">
            Port<br>
            <input type="number" min="1000" max="10000" id="port" name="port" required />
        </label>
        <br><br>

        <input type="hidden" name="action" value="set_application_port" />
        <button class="button confirm" type="submit"><?= __("Set port") ?></button>
    </form>

    <hr>

    <!-- Restore backup --> 
    <form action="index.php" method="post">
        <h1><?= __("Restore a backup") ?></h1>

        <label for="server">
            Server: (must be current server)<br>
            <input type="text" id="server" name="server" value="<?php echo $server_name ?>" required/>
        </label>
        <br><br>

        <label for="date">
            Date:<br>
            <input type="date" id="date" name="date" />
        </label>
        <br><br>

        <label for="time">
            Time: (optional)<br>
            <input type="time" id="time" name="time" />
        </label>

        <br><br>
        
        <select name="user" class="vst-list">
            <option value=""><?= __("Select a user") ?></option>
            <?php
            $users = Vesta::exec("v-list-users", "json");
            ksort($users);

            foreach ($users as $user_name => $value) {
                echo "<option value=\"$user_name\">$user_name</option>";
            }
            ?>
        </select>
        <br><br>

        <input type="hidden" name="action" value="backup" />
        <input type="hidden" name="sub_action" value="restore" />
        <button class="button confirm" type="submit"><?= __("Restore") ?></button>
    </form>
</div>