<?

namespace lastguest;

/**
 * cURL Object Oriented API
 * @author Stefano Azzolini <lastguest@gmail.com>
 */
class cURL
{
    /**
     * The cURL resource descriptor
     * @var Resource
     */
    private $curl = null;

    /**
     * Call curl_init and store the resource internally.
     * @param string $url The URL (default:null)
     */
    public function __construct($url = null)
    {
        return $this->init($url);
    }

    /**
     * Magic Method for proxying calls for this class to curl_* procedurals
     * @param  string $n    Function name
     * @param  array $p     Call parametrs
     * @return mixed        The called function return value
     */
    public function __call($n, $p)
    {
        if ($n == 'init' || $n == 'multi_init') {
            // Close the connection if it was opened.
            if ($this->curl) curl_close($this->curl);
            // Save the resource internally
            return $this->curl = call_user_func_array('curl_' . $n, $p);
        } elseif ($n == 'exec') {
            array_unshift($p, $this->curl);
            $result = call_user_func_array('curl_' . $n, $p);
            $this->close();
            return $result;
        } else {
            // Inject the current resource to the function call
            array_unshift($p, $this->curl);
            return call_user_func_array('curl_' . $n, $p);
        }
    }
}
