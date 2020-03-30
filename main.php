<?php
//
//This is a custom object used to send back data to javascript. 
//it contains response code, data to send back, boolean to indicate if there is an error
//and string to hold error message if any. 
class Ajax implements \JsonSerializable
{
    private ?string $error;
    private array $data;
    private bool $hasError;

    /**
     * @method mixed __construct()
     *
     * @param integer $code
     * @param array $data
     * @param string $error
     */
    public function __construct(int $code, array $data = null, string $error = null)
    {
        http_response_code($code);
        $this->error = $error;
        $this->data = (is_null($data) ? [] : $data);
        $this->hasError = (is_null($error) ? false : true);
    }
    /**
     * @method array jsonSerialize()
     *  overrid the interface method to return our own custom representation of the object
     * @return void
     */
    public function jsonSerialize()
    {
        return [
            'status' => http_response_code(),
            'data' => $this->data,
            'hasError' => $this->hasError,
            'errorMessage' => ($this->hasError ? $this->error : null)
        ];
    }

    /**
     * @method string __toString()
     * Return a sting representation of the object. Doing this will invoke the jsonSerialize on the interface
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}


//get post data
$data = json_decode(file_get_contents('php://input'));

//do some database operations. i.e fetch from database 
// for this example ill just return a custom array with dummy data

//here we dont echo the results, rather we create an Ajax object with the array
$response = new Ajax(200, ["text" => $data->advice]);

//test 400. comment out the above
// $response = new Ajax(400, null, "NO DATA SENT/ BAD REQUEST");

//test 201
// $response = new Ajax(201, ["text"=> "data inserted"]);

//we can then echo the response object. no need for encoding because that is andled internally
echo $response;