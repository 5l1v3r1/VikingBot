<?php

/**
 * Plugin that outputs any content from the file db/fileReaderOutput.db
 * to the channel specified. When the content is read the file is truncated.
 *
 * If you have SVn commit hooks etc you want to get content from they should
 * pipe their data into this file.
 */
class fileReaderPlugin implements pluginInterface {

	var $socket, $lastCheck, $config, $startTime;
	var $channel = '';
	var $db      = 'db/fileReaderOutput.db';

	function init($config, $socket) {
		if (!isset($config['plugins']['fileReader'])) {
			$config['plugins']['fileReader'] = array('channel' => '');
		}
		$this->channel = $config['plugins']['fileReader']['channel'];
		$this->socket = $socket;
		$this->lastCheck = 0;
		$this->config = $config;
		$this->startTime = time();
		if(!is_file($this->db)) {
			touch($this->db);
		}
	}

	function onData($data) {
	}

	function tick() {
		if((time() - $this->config['waitTime']) < $this->startTime) {
			return;
		}

		if($this->lastCheck < time()) {
			clearstatcache();
			if(filemtime($this->db) >= $this->lastCheck) {
				$data = file($this->db);
				foreach($data as $row) {
					sendMessage($this->socket, $this->channel, $row);
					usleep(300000);
				}
				$h = fopen($this->db, 'w+');
				fclose($h);
				$data = null;
				$h = null;
			}
			$this->lastCheck = time();
		}
	}

	function onMessage($from, $channel, $msg) {
	}

	function destroy() {
		$this->socket = null;
	}
}
