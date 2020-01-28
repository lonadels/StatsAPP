<?

namespace SwiftOf\StatsApp\Results;

class ResultError extends Result
{
    /** 
     * @var int $errorCode          код ошибки 
     * @var string $errorMessage    описание ошибки 
     */
    protected $errorCode, $errorMessage;

    /** @var array сообщения и коды ошибок */
    private const MESSAGES = [
        -1  => "Undefined error",
        1   => "Permission denied",
        2   => "One or more required arguments is missing",
        3   => "Method not exists",
        4   => "Incorrect token"
    ];

    /**
     * @param int           код ошибки
     * @return string       описание ошибки        
     */
    private function getMessage(int $code): string
    {
        return $this::MESSAGES[$code] ?? $this::MESSAGES[-1];
    }

    function __construct(int $code)
    {
        $this->errorCode = $code;
        $this->errorMessage = $this->getMessage($code);
    }
}
