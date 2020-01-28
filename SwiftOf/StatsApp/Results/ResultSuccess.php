<?

namespace SwiftOf\StatsApp\Results;

class ResultSuccess extends Result
{
    /** @var mixed $response результат работы API */
    protected $response;
    function __construct($response)
    {
        $this->response = $response;
    }
}
