<?php

class autoOpPlugin extends basePlugin {

	private $autoOpConfig;

	public function __construct($config, $socket) {
		if (!isset($config['plugins']['autoOp'])) {
			$config['plugins']['autoOp'] = array();
		}
		parent::__construct($config, $socket);
		$this->autoOpConfig = $config['plugins']['autoOp'];
	}

	public function onData($data) {
		if (isset($this->autoOpConfig['mode']) && $this->autoOpConfig['mode']) {
			if (strpos($data,'JOIN :') !== false) {
				$bits = explode(" ", $data);
				$nick = getNick(@$bits[0]);
				$channel = trim(str_replace(":", '', @$bits[2]));

				if ($this->autoOpConfig['mode'] == 1) {
					if (in_array($nick, $this->autoOpConfig['channel'][$channel])) {
						sendData($this->socket, "MODE {$channel} +o {$nick}");
					}
				} elseif ($this->autoOpConfig['mode'] == 2) {
					sendData($this->socket, "MODE {$channel} +o {$nick}");
				}
			}
		}
	}

}
