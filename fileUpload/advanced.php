<?php
	require_once __DIR__ . '/vendor/qiniu/php-sdk/autoload.php';

	// 通常用tmp_name来判断文件是否获取到
	if (isset($_FILES['file']['tmp_name']) && current($_FILES['file']['tmp_name']) && current($_FILES['file']['error']) == 0) {
		$suffixType = ['png', 'jpg', 'jpeg', 'gif', 'txt', 'mp4', 'mp3'];
		$fileType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'text/plain', 'video/mp4', 'audio/mp3'];
		// 1. 过滤
		preg_match('/\.{1}[a-zA-Z]+$/u', current($_FILES['file']['name']), $suffix);
		if (in_array(trim(current($suffix), '.'), $suffixType) && in_array(current($_FILES['file']['type']), $fileType) && intval(current($_FILES['file']['size'])) > 1000 && intval(current($_FILES['file']['size'])) < 10000000) {
			// 2. 上传到七牛云
			$result = qnUpload($_FILES);

			if ($result) {
				// 3. 返回相应的json结果
				echo json_encode(array('id' => $result));
				// 下面就可以把文件的url等数据写入数据库了，这里就不演示了
			}
		}
	}

	/**
	 * [七牛上传]
	 * @param  array  $file [文件数组]
	 * @return [mixed]      [link / false]
	 */
	function qnUpload($file = array())
	{
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = 'mpV8ObIj3oDonE2XPHWXKWeQcPXJ6ddPl2Fu6hs6';
        $secretKey = 'KTv9PYm7GrUwowUb7utUX-myGdQQYBMJbUuShzMX';

        // 空间名
        $bucket = 'fsociety';

        // 构建鉴权对象
        $auth = new \Qiniu\Auth($accessKey, $secretKey);
        
        $return = $error = [];

        // 上传到七牛后保存的文件名，用sha1算法生成唯一文件名称，防止重复
        $name = sha1(current($file['file']['name']) . time());

        // 文件路径
        $filePath = current($file['file']['tmp_name']);

        // 生成上传Token
        $uptoken = $auth->uploadToken($bucket);

        // 构建 UploadManager 对象
        $uploadMgr = new \Qiniu\Storage\UploadManager();

        // 返回文件信息或者错误信息
        list($return, $error) = $uploadMgr->putFile($uptoken, $name, $filePath);

        return $error ? : $return['key'];
	}

	exit;
