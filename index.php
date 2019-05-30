<?php
    /**
     * handleSubmit
     * Class for handling a post request from a form
     */
    class handleSubmit {

        /**
         * connect
         * Establishes a database connection
         */
        function connect() {
            $host = '';
            $user = '';
            $pass = '';
            $dbse = '';

            $conn = mysqli_connect($host, $user, $pass, $dbse);
            return $conn;
        }

        /**
         * sanitise
         * @var $data
         * recieves a varaible from the post object - sanitises it for the database
         */
        function sanitise($data) {
            if ($data == ''){
                return NULL;
            }else{
                return htmlentities($data);
            }
        }

        /**
         * handlePost
         * @var $postItems
         * Receives the post object and processes it
         */
        function handlePost($postItems) {

            //Connect to the database
            $conn = $this->connect();

            //validate the POST items
            //assuming there are 2 items submitted - email and terms
            $email = $this->sanitise($_POST['email']);
            $terms = $this->sanitise($_POST['terms']);


            if ($email != NULL && $terms != NULL) {

                //Check if the user already exists in the database
                $query = "SELECT * FROM `table_name` WHERE email = '$email'";
                $execute = mysqli_query($conn, $query); 

                $rowcount=mysqli_num_rows($execute);

                if ($rowcount > 0){
                    return 'Already A Member';
                }else{
                    //Query for running the insert
                    $query = "INSERT INTO `table_name` (email, terms) VALUES ('$email', '$terms')";
                    $execute = mysqli_query($conn, $query); 

                    return 'Success';
                }

            }else{
                return 'Not Valid';
            }
        }
    }

    /**
     * Instantiate the class if the handler recieves a POST request
     */
    if ($_POST) {
        $submit = new handleSubmit;
        $response = $submit->handlePost($_POST);
        echo $response;
    }

?>