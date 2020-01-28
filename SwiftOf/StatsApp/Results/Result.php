<?

namespace SwiftOf\StatsApp\Results;

class Result
{
    function __get($v)
    {
        return $this->$v;
    }
}
