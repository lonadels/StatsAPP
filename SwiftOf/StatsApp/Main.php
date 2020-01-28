<?

namespace SwiftOf\StatsApp;

use SwiftOf\StatsApp\Results\Result;
use SwiftOf\StatsApp\Results\ResultError;
use SwiftOf\StatsApp\Results\ResultSuccess;

/**
 * @author SwiftSoft
 * @method void result(Result $result)
 * @method void checkArgs(string|array $needle)
 */
class Main
{
    /** @var array $args аргументы из URL */
    public $args;

    function __construct(array $args)
    {
        $this->args = $args;
        if (!$this->checkArgs('method')) return $this->result(new ResultError(2));

        switch ($this->args['method']) {
            case "checkToken":
                if (!$this->checkArgs('token')) return $this->result(new ResultError(2));
                $res = VKAPI::method("secure.checkToken", ["token" => $this->args['token']]);
                if (isset($res->error)) return $this->result(new ResultError($res->error->error_code == 15 ? 4 : -1));
                $this->result(new ResultSuccess($res->response));
                break;

            case "getToken":
                if (!$this->checkArgs(['username', 'password'])) return $this->result(new ResultError(2));
                $res = VKAPI::getToken($this->args['username'], $this->args['password']);
                if (isset($res->error)) return $this->result(new ResultError(-1));
                $this->result(new ResultSuccess($res));
                break;

            default:
                $this->result(new ResultError(3));
        }
    }

    /**
     * @param string|array $needle 
     */
    public function checkArgs($needle): bool
    {
        if (is_array($needle)) {
            foreach ($needle as $need)
                if (!in_array($need, array_keys($this->args)))
                    return false;
            return true;
        } else
            return in_array($needle, array_keys($this->args));
    }

    /**
     * 
     */
    public function result(Result $result): void
    {
        if ($result instanceof ResultError)
            $output = [
                "error_code" => $result->errorCode,
                "error_msg" => $result->errorMessage,
            ] + ($this->args ? ["request_params" => $this->args] : []);
        elseif ($result instanceof ResultSuccess)
            $output = [
                "response" => $result->response
            ];

        $json = json_encode($output);
        print $json;

        exit;
    }
};
