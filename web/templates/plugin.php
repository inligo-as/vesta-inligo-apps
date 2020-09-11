<?php
    
if (!class_exists('Vesta')) die('Vesta is not defined.'); 

// Read server name
$server_name = '';
$server_name_path = '/usr/local/vesta/plugins/vesta-inligo-apps/plugin-data/server-name.txt';
$f = fopen($server_name_path, 'rw');
$_server_name = fread($f, 200);
if ($_server_name && count($_server_name) > 3) $server_name = $_server_name;
fclose($f);

?>

<div class="l-center units vestacp-web-apps">
    <!-- Install app -->
    <form action="index.php" method="post">
        <h1><?= __("Install a web-app") ?></h1>

        <select name="app" class="vst-list" required>
            <option value=""><?= __("Select an app") ?></option>
            <option value="wordpress">Wordpress</option>
            <!-- <option value="moodle">Moodle</option> -->
        </select>
        <br><br>

        <select name="web_domain" class="vst-list" required>
            <option value=""><?= __("Select a web domain") ?></option>
            <?php
            $users = Vesta::exec("v-list-users", "json");
            ksort($users);

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

    <!-- Restore backup --> 
    <form action="index.php" method="post">
        <h1><?= __("Restore a backup") ?></h1>

        <input type="text" name="server" value="<?php echo $server_name ?>" required/>
        <input type="date" name="date" required />
        <input type="time" name="time" />
        <br><br>

        <select name="user" class="vst-list" required>
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