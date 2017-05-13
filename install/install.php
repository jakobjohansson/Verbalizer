<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="../admin/assets/css/style.css" rel="stylesheet" />
	<title>Verbalizer</title>
</head>
<body class="login">
	<div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 outer">
                <div class="inner">
<?php

// if file exists, include to show error message
if (file_exists(dirname(__FILE__).'/define.php')) {
    include(dirname(__FILE__).'/define.php');
}

// if settings are already defined, tell user to delete define.php
if (!defined("DB_HOST") || !defined("DB_USER") || !defined("DB_PASS") || !defined("DB_DATABASE")) {

    //otherwise begin installation
    if (!isset($_POST['submit'])) {
        ?>

		<h1>Installing Verbalizer</h1>
		<p>Take some time to configure the website. We need your database settings. It will not be saved anywhere except on your computer. If you need help regarding the settings, contact your web administrator.</p>
		<form action="install.php" method="post">
			<label for="dbhost">Server</label>
			<input type="text" name="dbhost" id="dbhost" placeholder="e.g localhost" value="localhost" />
			<label for="dbuser">Database username</label>
			<input type="text" name="dbuser" id="dbuser" placeholder="e.g root, user, etc" />
			<label for="dbpass">Database password</label>
			<input type="password" name="dbpass" id="dbpass" placeholder="for new servers, this normally blank" />
			<label for="dbdb">Database</label>
			<input type="text" name="dbdb" id="dbdb" placeholder="enter the database name you have chosen" />
			<input type="submit" value="Try!" id="submit" name="submit" />
		</form>
			
	<?php

    } else {
        // execute after button is pressed
        $dbhost = filter_var($_POST['dbhost'], FILTER_SANITIZE_STRING);
        $dbuser = filter_var($_POST['dbuser'], FILTER_SANITIZE_STRING);
        $dbpass = trim($_POST['dbpass']);
        $dbdb = filter_var($_POST['dbdb'], FILTER_SANITIZE_STRING);

        // needs to do some string regexp here probably
        if (empty($dbhost) || empty($dbuser) || empty($dbdb)) {
            echo "<h1>Error</h1><p>All fields need to be filled out.</p>";
            exit;
        }

        $file = fopen("define.php", "w");
        $write = "<?php\ndefine('DB_HOST', \"$dbhost\");\ndefine('DB_USER', \"$dbuser\");\ndefine('DB_PASS', \"$dbpass\");\ndefine('DB_DATABASE', \"$dbdb\");\n";
        if (fwrite($file, $write)) {
            fclose($file);
            // success!
            // create tables

            $db = new mysqli($dbhost, $dbuser, $dbpass, $dbdb);
            if ($db->connect_errno > 0) {
                unlink("define.php");
                header("Location: install.php?error");
                exit;
            }

            $sql = "CREATE TABLE IF NOT EXISTS `vb_meta` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `vb_key` varchar(255) NOT NULL,
                `vb_value` varchar(255) NOT NULL,
                `description` text NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $sql .= "CREATE TABLE IF NOT EXISTS `vb_post` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `content` text NOT NULL,
                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `authorID` int(11) DEFAULT NULL,
                `authorName` varchar(255) NOT NULL,
                `public` tinyint(1) NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`),
                UNIQUE KEY `id` (`id`),
                KEY `id_2` (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";

            $sql .= "CREATE TABLE IF NOT EXISTS `vb_user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `postcount` int(11) NOT NULL DEFAULT '0',
                `password` varchar(255) NOT NULL,
                `age` int(11) NOT NULL,
                `city` varchar(255) NOT NULL,
                `website` varchar(255) NOT NULL,
                `aliases` varchar(255) NOT NULL,
                `bio` text NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

            $sql .= "INSERT INTO `vb_meta` (`id`, `vb_key`, `vb_value`, `description`) VALUES
                (1, 'active', 'true', 'Blog active or not. If not, redirecting to views/deactivated.php'),
                (2, 'pagination', 'false', 'Set pagination on or off'),
                (3, 'posts_per_page', '5', 'Posts per page'),
                (4, 'comments', 'false', 'Comments enabled or disabled');";

            if ($db->multi_query($sql) === false) {
                echo "<h1>Error</h1><p>An error occured while trying to add tables.</p>";
                exit;
            } else {
                $file = fopen("define.php", "a");
                $write = "define('DB_INSTALLED', true);";
                fwrite($file, $write);
                fclose($file); ?>
				<h1>Success!</h1>
				<p>Settings were successfully saved! Now, lets make your user!</p> 
				<p><a href="register.php">Make your user!</a></p>
				<?php

            }
            $db->close();
        } else {
            fclose($file); ?>

			<h1>Something went wrong</h1>
			<p>We couldn't make the define.php file. Please make sure the VB folder has write privelegies and try again.</p>
		<?php

        }
    }
} else {
    // error message
    ?>

	<h1>No access</h1>
	<p>You can't access this file after a successfull installation. If you have problems or your installation messed up, you can delete <strong>lib/define.php</strong> to start this process over. Note that your posts and users won't be removed - you only have to set up your connection again.</p>
<?php 
}
?>
	            </div>
            </div>
        </div>
            <?php
            if (isset($_GET['error'])) {
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <div id="response" style="opacity: 1;">Couldn't connect to database. Try again!</div>
                    </div>
                </div>
                <?php

            }
            ?>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>