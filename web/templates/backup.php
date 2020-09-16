<!-- Restore backup -->
<form action="index.php" method="post">
    <h1><?= __("Restore a backup") ?></h1>

    <label for="server">
        Server: (must be current server)<br>
        <input type="text" id="server" name="server" value="<?php echo $server_name ?>" required />
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