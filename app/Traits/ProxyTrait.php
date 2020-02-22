<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * 向oauth 服务器发送的provider对应到 config/auth.php中的provider
 */
trait ProxyTrait
{

	/**
	 * 获取访问令牌
	 * https://learnku.com/docs/laravel/5.6/passport/1380#49cdea
	 */
	public function authenticate($provider = "")
	{
		$client = new Client();

		try {
			$url = request()->root() . '/oauth/token';

			$params = array_merge(config('passport.proxy'), [
				'username' => request('username'),
				'password' => request('password'),
			]);
			//print_r($params);exit;
			
			if ($provider) {
				$params['provider'] = $provider;
			}

			$respond = $client->request('POST', $url, ['form_params' => $params]);
			// print_r($respond->getBody()->getContents());exit;
		} catch (RequestException $e) {
			//print_r($e);exit;
			abort(401, "登录服务器 token 错误:" . $e->getMessage());
		}

		if ($respond->getStatusCode() !== 401) {
			return json_decode($respond->getBody()->getContents(), true);
		}
		abort(401, '账号或密码错误');
	}

	/**
	 * 刷新访问令牌
	 */
	public function getRefreshToken($provider = "")
	{
		$client = new Client();

		try {
			$url = request()->root() . '/oauth/token';

			$params = array_merge(config('passport.refresh_token'), [
				'refresh_token' => request('refresh_token'),
			]);

			if ($provider) {
				$params['provider'] = $provider;
			}

			$respond = $client->request('POST', $url, ['form_params' => $params]);
		} catch (RequestException $e) {
			abort(401, "请求刷新 token 错误:" . $e->getMessage());
		}

		if ($respond->getStatusCode() !== 401) {
			return json_decode($respond->getBody()->getContents(), true);
		}

		abort(401, "刷新 token 错误:" . $e->getMessage());
	}
}
