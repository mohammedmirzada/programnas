<?php

/**
 * Mohamemd D Mirzada
 */
class crypto{

	private $_data_tool = array(
		'AES-128-CTR',
		'{{ThePlan=has-been@locked!@@(232);;}{Family:Dilshad,+Shireen,+Mohammed,+Hawre,+Goraz,+Hawas,+Zhinma}}',
		0,
		'20575712320575745970572062920575770572062905720670572062926290572939106411121'
	);

	function __construct($type=false){
		if ($type) {
			$ciphering = "BF-CBC";
			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;
			$encryption_iv = random_bytes($iv_length);
			$encryption_key = openssl_digest($this->_data_tool[1], 'MD5', TRUE);

			$this->_data_tool = array(
				$ciphering,
				$encryption_key,
				$options,
				$encryption_iv
			);
		}
	}

	public function Encrypt($str){
		return openssl_encrypt(
			$str, 
			$this->_data_tool[0], 
			$this->_data_tool[1], 
			$this->_data_tool[2], 
			$this->_data_tool[3]
		);
	}

	public function Decrypt($encrypted_str){
		return openssl_decrypt (
			$encrypted_str, 
			$this->_data_tool[0], 
			$this->_data_tool[1], 
			$this->_data_tool[2], 
			$this->_data_tool[3]
		);
	}

}

?>