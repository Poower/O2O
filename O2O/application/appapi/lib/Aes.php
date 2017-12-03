<?php
namespace app\appapi\lib;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\appapi\lib
 */
class Aes {


    /*
     *
     * AES/CBC/NoPadding 16 不支持
AES/CBC/PKCS5Padding 32 16
AES/CBC/ISO10126Padding 32 16
AES/CFB/NoPadding 16 原始数据长度
AES/CFB/PKCS5Padding 32 16
AES/CFB/ISO10126Padding 32 16
AES/ECB/NoPadding 16 不支持
AES/ECB/PKCS5Padding 32 16 #################there
AES/ECB/ISO10126Padding 32 16
AES/OFB/NoPadding 16 原始数据长度
AES/OFB/PKCS5Padding 32 16
AES/OFB/ISO10126Padding 32 16
AES/PCBC/NoPadding 16 不支持
AES/PCBC/PKCS5Padding 32 16
AES/PCBC/ISO10126Padding 32 16

     */
    private $key = null;

    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        $this->key =config('app.aeskey');
    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);

        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);

        return $data;

    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {//AES 128 ECB ADDPADING
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;
    }
    /**
     * Array
    (
    [0] => cast-128
    [1] => gost
    [2] => rijndael-128
    [3] => twofish
    [4] => cast-256
    [5] => loki97
    [6] => rijndael-192
    [7] => saferplus
    [8] => wake
    [9] => blowfish-compat
    [10] => des
    [11] => rijndael-256
    [12] => serpent
    [13] => xtea
    [14] => blowfish
    [15] => enigma
    [16] => rc2
    [17] => tripledes
    [18] => arcfour
    )
    Array
    (
    [0] => cbc
    [1] => cfb
    [2] => ctr
    [3] => ecb
    [4] => ncfb
    [5] => nofb
    [6] => ofb
    [7] => stream
    )


     */

}