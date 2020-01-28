<?

namespace SwiftOf\StatsApp;

use Exception;
use lastguest\cURL;

class VKAPI
{
    const V = 5.103;
    const APP = [
        "ID"     => 2274003,
        "SECRET" => 'hHbZxrka2uZ6jB1inYsH'
    ];

    private static $token;

    private static function request(string $url)
    {
        $http = new cURL;

        $http->setopt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $http->setopt(CURLOPT_FOLLOWLOCATION, TRUE);
        $http->setopt(CURLOPT_URL, $url);
        $http->setopt(CURLOPT_REFERER, $url);
        $http->setopt(CURLOPT_RETURNTRANSFER, TRUE);

        return $http->exec();
    }

    private static function query($url, $args)
    {
        $args['v'] = self::V;
        $args['client_secret'] = self::APP['SECRET'];

        return json_decode(self::request("{$url}?" . http_build_query($args)));
    }

    private static function getService(): bool
    {
        $query = self::query("https://oauth.vk.com/token", [
            'client_id' => self::APP['ID'],
            'grant_type' => "client_credentials"
        ]);

        if (isset($query->error)) return false;

        self::$token = $query->access_token;
        return true;
    }

    public static function getToken(string $username, string $password)
    {
        return self::query("https://oauth.vk.com/token", [
            'client_id'     => self::APP['ID'],
            'scope'         => "messages,wall,offline",
            'grant_type'    => "password",
            '2fa_support'   => 0,

            'username'      => $username,
            'password'      => $password
        ]);
    }

    /**
     * @param string $method    название метода
     * @param array $args       аргуметы
     * 
     * @return stdClass         объект json результата
     */
    public static function method(string $method, array $args = [])
    {
        if (empty(self::$token) && !self::getService()) throw new Exception("Token not defined");

        $args['access_token'] = self::$token;
        return self::query("https://api.vk.com/method/{$method}", $args);
    }
}
