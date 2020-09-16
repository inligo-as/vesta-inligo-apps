<!-- Link up web domain with port -->
<div class="units l-center vestacp-web-apps">
    <form action="index.php" method="post">
        <h1><?= __("Set application port") ?></h1>
        <p><em>Remember to change nginx proxy after performing this action in domain settings. Log in as the user that owns the domain.</em></p>

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
            Port:<br>
            <input type="number" min="1000" max="10000" id="port" name="port" required />
        </label>
        <br><br>

        <input type="hidden" name="action" value="set_application_port" />
        <button class="button confirm" type="submit"><?= __("Set port") ?></button>
    </form>
</div>