<?php

/**
 * Plugin that performs upgrade of the bot, then
 * restarts it so it can start up with the new version
 * This plugin requires access to "git pull" so all files
 * should be owned by the user that is running the bot
 *
 * You can start an upgrade via the command !upgrade [admin password]
 */
class upgradePlugin extends basePlugin {

	/**
	 * @return array[]
	 */
	public function help() {
		return array(
			array(
				'command'     => 'upgrade [adminPassword]',
				'description' => 'Upgrades the bot and its plugins via git pull.'
			)
		);
	}

	public function onMessage($from, $channel, $msg) {
		if(stringStartsWith($msg, "{$this->config['trigger']}upgrade")) {
			$bits = explode(" ", $msg);
			$pass = $bits[1];
			if(strlen($this->config['adminPass']) > 0 && $pass != $this->config['adminPass']) {
				sendMessage($this->socket, $channel, "{$from}: Wrong password");
			} else {
				$restartRequired = false;
				sendMessage($this->socket, $channel, "{$from}: Starting upgrade of bot and its plugins...");

				$response = trim( shell_exec("git pull") );
				if (empty($response)) {
					sendMessage($this->socket, $channel, "{$from}: Error upgrading core. Check permissions!");
				} elseif($response != 'Already up-to-date.') {
					$restartRequired = true;
					sendMessage($this->socket, $channel, "{$from}: Upgrading core: {$response}");
				}

				$coreDir = getcwd();
				$pluginsRecDirIterator = new RecursiveDirectoryIterator('./');
				foreach (new RecursiveIteratorIterator($pluginsRecDirIterator) as $gitDir) {
					if (stringEndsWith($gitDir, ".git/..")) {
						chdir($gitDir);
						$response = trim( shell_exec("git pull") );
						if (empty($response)) {
							sendMessage($this->socket, $channel, "{$from}: Error upgrading sub git. Check permissions!");
						} elseif ($response != 'Already up-to-date.') {
							$restartRequired = true;
							sendMessage($this->socket, $channel, "{$from}: Upgrading sub git: {$response}");
						}
						chdir($coreDir);
					}
				}

				if ($restartRequired) {
					sendMessage($this->socket, $channel, "{$from}: Restarting...");
					sendData($this->socket, 'QUIT :Restarting due to upgrade');
					die(exec('sh start.sh > /dev/null &'));
				} else {
					sendMessage($this->socket, $channel, "{$from}: Everything up to date, not restarting.");
				}
			}
		}
	}

}
