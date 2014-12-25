<?php

/**
 * Plugin that responds with bot memory usage information
 */
class memoryPlugin extends basePlugin {

	/**
	 * @return array[]
	 */
	public function help() {
		return array(
			array(
				'command'     => 'memory',
				'description' => 'Responds with information about memory usage.'
			)
		);
	}

	public function onMessage($from, $channel, $msg) {
		if(stringEndsWith($msg, "{$this->config['trigger']}memory")) {
			$usedMem = round(((memory_get_usage() / 1024) / 1024),2);
			$freeMem = round(($this->config['memoryLimit'] - $usedMem),2);
			sendMessage($this->socket, $channel, $from.": Memory status: {$usedMem} MB used, {$freeMem} MB free.");
			$usedMem = null;
			$freeMem = null;
		}
	}

}
