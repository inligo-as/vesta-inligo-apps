<!-- Install dependencies -->
<div class="units l-center vestacp-web-apps">
    <form action="index.php" method="post">
        <h1><?= __(($server_name ? "Reinstall" : "Install") . " dependencies and cron jobs") ?></h1>
        <p><em>Installs dependencies and enables remote backups into S3 bucket.</em></p>

        <label for="server">
            Server: (must be current server)<br>
            <input type="text" id="server" name="server" value="<?php echo $server_name ?>" required />
        </label>
        <br><br>
        <label for="aws_access_key">
            AWS_ACCESS_KEY<br>
            <input type="text" id="aws_access_key" name="aws_access_key" size="50" />
        </label>
        <br><br>
        <label for="aws_secret_key">
            AWS_SECRET_KEY<br>
            <input type="text" id="aws_secret_key" name="aws_secret_key" size="50" />
        </label>
        <br><br>
        <input type="hidden" name="action" value="install_deps" />
        <button class="button confirm" type="submit"><?= __($server_name ? "Reinstall" : "Install") ?></button>
    </form>
</div>